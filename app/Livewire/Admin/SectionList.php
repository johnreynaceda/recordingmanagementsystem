<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Staff;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Livewire\Component;

class SectionList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $grade_level_id;
    public $selected_academic_year_id;

    public function mount()
    {
        $this->grade_level_id = request('id');
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Section::query()
                    ->where('grade_level_id', $this->grade_level_id)
                    ->where('academic_year_id', $this->selected_academic_year_id)
            )
            ->headerActions([
                CreateAction::make('section')
                    ->label('New Section')
                    ->icon('heroicon-o-plus')
                    ->iconPosition(IconPosition::After)
                    ->action(function ($data) {
                        Section::create([
                            'grade_level_id' => $this->grade_level_id,
                            'name' => $data['name'],
                            'academic_year_id' => $this->selected_academic_year_id,
                        ]);
                    })
                    ->form([
                        TextInput::make('name')->required(),
                    ])
                    ->modalWidth('xl')
                    ->modalHeading('Create Section'),
            ])
            ->columns([
                TextColumn::make('name')->label('NAME'),
                TextColumn::make('staff')
                    ->label('TEACHER')
                    ->formatStateUsing(fn($record) => $record->staff ? $record->staff->firstname . ' ' . $record->staff->lastname : 'Not Assigned'),
                TextColumn::make('academicYear.name')
                    ->label('ACADEMIC YEAR'),
            ])
            ->filters([
                SelectFilter::make('academic_year_id')
                    ->label('Academic Year')
                    ->options(AcademicYear::pluck('name', 'id')->toArray())
                    ->default($this->selected_academic_year_id)
                    ->query(function ($query, array $data) {
                        if (filled($data['value'])) {
                            $query->where('academic_year_id', $data['value']);
                        }
                    }),
            ])
            ->actions([
                Action::make('teacher')
                    ->label('Assign Teacher')
                    ->icon('heroicon-o-user-plus')
                    ->button()
                    ->color('success')
                    ->action(function ($record, $data) {
                        $record->update([
                            'staff_id' => $data['staff'],
                        ]);
                    })
                    ->form([
                        Select::make('staff')
                            ->label('Teacher')
                            ->options(Staff::all()->mapWithKeys(function ($record) {
                                return [$record->id => $record->firstname . ' ' . $record->lastname];
                            }))
                            ->required(),
                    ])
                    ->modalWidth('xl')
                    ->visible(fn($record) => $record->staff_id == null || $record->staff == null),
                EditAction::make('edit')
                    ->color('success')
                    ->action(function ($record, $data) {
                        $record->update([
                            'name' => $data['name'],
                        ]);
                    })
                    ->form([
                        TextInput::make('name')->required(),
                    ])
                    ->modalWidth('xl')
                    ->modalHeading('Edit Section'),
                DeleteAction::make('delete'),
            ])
            ->bulkActions([
                // ...
            ])
            ->emptyStateHeading('No Section yet')
            ->emptyStateDescription('Once you add the first section, it will appear here.');
    }

    public function render()
    {
        return view('livewire.admin.section-list', [
            'name' => GradeLevel::where('id', $this->grade_level_id)->first()->name,
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
        ]);
    }
}
