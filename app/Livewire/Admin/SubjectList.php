<?php

namespace App\Livewire\Admin;

use App\Models\GradeLevel;
use App\Models\GradeLevelSubject;
use App\Models\Section;
use App\Models\Staff;
use App\Models\User;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class SubjectList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $grade_level_id;
    public function mount(){
        $this->grade_level_id = request('id');
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(GradeLevelSubject::query()->where('grade_level_id', $this->grade_level_id))->headerActions([
               CreateAction::make('section')->label('New Subject')->icon('heroicon-o-plus')->iconPosition(IconPosition::After)->action(
                function($data){
                    GradeLevelSubject::create([
                        'grade_level_id' => $this->grade_level_id,
                        'subject_name' => $data['name'],
                    ]);
                }
               )->form([
                TextInput::make('name')->required()
               ])->modalWidth('xl')->modalHeading('Create Subject')
            ])
            ->columns([
               
                TextColumn::make('subject_name')->label('NAME'),
                
             
            ])
            ->filters([
                // ...
            ])
            ->actions([
             EditAction::make('edit')->color('success')->action(
                function($record, $data){
                   $record->update([
                    'subject_name' => $data['subject_name'],
                   ]);
                }
               )->form([
                TextInput::make('subject_name')->required()
               ])->modalWidth('xl')->modalHeading('Edit Subject'),
               DeleteAction::make('delete'),
            ])
            ->bulkActions([
                // ...
            ])->emptyStateHeading('No Subjects yet')->emptyStateDescription('Once you add the first subject, it will appear here.');
    }

    public function render()
    {
        return view('livewire.admin.subject-list',[
            'name' => GradeLevel::where('id', $this->grade_level_id)->first()->name
        ]);
    }
}
