<?php

namespace App\Livewire\Teacher;

use App\Models\Section;
use App\Models\StudentGrade;
use App\Models\StudentRecord;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use App\Models\Student;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\ViewColumn;

class Grading extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $grade = [];

    public function table(Table $table): Table
    {
        return $table
            ->query(StudentRecord::query()->whereIn('section_id', auth()->user()->staff->sections->pluck('id')->toArray()))->columns([
               
                TextColumn::make('student')->label('NAME')->formatStateUsing(
                    fn($record) => strtoupper($record->student->firstname. ' ' . $record->student->lastname)
                )->searchable(),
                TextColumn::make('section.name')->label('SECTION')->searchable(),
              
             
            ])
            ->filters([
                SelectFilter::make('status')
                ->options(Section::whereIn('id', auth()->user()->staff->sections->pluck('id')->toArray())->pluck('name', 'id'))
                ->attribute('section_id')
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('upload')->label('UPLOAD')->icon('heroicon-o-arrow-up-on-square-stack')->color('success')->action(
                        function($record,$data){
                            foreach ($this->grade as $key => $value) {
                                StudentGrade::create([
                                    'student_id' => $record->student_id,
                                    'name' =>  $value->getClientOriginalName(),
                                    'file_path' => $value->store('Grade', 'public')
                                ]);
                            }
                            
                        }
                    )->form([
                        ViewField::make('grade')
                        ->view('filament.forms.upload-grade')
                    //     FileUpload::make('grade')
                    ])->modalWidth('xl'),
                    Action::make('view')->label('VIEW GRADES')->icon('heroicon-o-folder-open')->color('warning'),
                ])->color('black')
            ])
            ->bulkActions([
                // ...
            ])->emptyStateHeading('No Section yet')->emptyStateDescription('Once you add the first section, it will appear here.');
    }

    public function render()
    {
        
        return view('livewire.teacher.grading');
    }
}
