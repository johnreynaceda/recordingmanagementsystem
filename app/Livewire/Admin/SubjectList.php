<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\GradeLevelSubject;
use App\Models\Staff;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Livewire\Component;

class SubjectList extends Component implements HasForms, HasTable
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

    private function teacherOptions(): array
    {
        return Staff::with('user')->get()->mapWithKeys(function ($staff) {
            return [$staff->id => $staff->firstname . ' ' . $staff->lastname];
        })->toArray();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                GradeLevelSubject::query()
                    ->where('grade_level_id', $this->grade_level_id)
                    ->where('academic_year_id', $this->selected_academic_year_id)
            )
            ->headerActions([
                CreateAction::make('subject')
                    ->label('New Subject')
                    ->icon('heroicon-o-plus')
                    ->iconPosition(IconPosition::After)
                    ->action(function ($data) {
                        GradeLevelSubject::create([
                            'grade_level_id' => $this->grade_level_id,
                            'subject_name' => $data['subject_name'],
                            'teacher_id' => $data['teacher_id'] ?? null,
                            'academic_year_id' => $this->selected_academic_year_id,
                        ]);
                    })
                    ->form([
                        TextInput::make('subject_name')->required(),
                        Select::make('teacher_id')
                            ->label('Assign Teacher')
                            ->options($this->teacherOptions())
                            ->searchable()
                            ->placeholder('Select a teacher')
                            ->nullable(),
                    ])
                    ->modalWidth('xl')
                    ->modalHeading('Create Subject'),
            ])
            ->columns([
                TextColumn::make('subject_name')->label('SUBJECT NAME'),
                TextColumn::make('teacher')
                    ->label('TEACHER')
                    ->formatStateUsing(fn($record) => $record->teacher
                        ? $record->teacher->firstname . ' ' . $record->teacher->lastname
                        : 'Not Assigned'),
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
                EditAction::make('edit')
                    ->color('success')
                    ->action(function ($record, $data) {
                        $record->update([
                            'subject_name' => $data['subject_name'],
                            'teacher_id' => $data['teacher_id'] ?? null,
                        ]);
                    })
                    ->form([
                        TextInput::make('subject_name')->required(),
                        Select::make('teacher_id')
                            ->label('Assign Teacher')
                            ->options($this->teacherOptions())
                            ->searchable()
                            ->placeholder('Select a teacher')
                            ->nullable(),
                    ])
                    ->modalWidth('xl')
                    ->modalHeading('Edit Subject'),
                DeleteAction::make('delete'),
            ])
            ->bulkActions([
                // ...
            ])
            ->emptyStateHeading('No Subjects yet')
            ->emptyStateDescription('Once you add the first subject, it will appear here.');
    }

    public function render()
    {
        return view('livewire.admin.subject-list', [
            'name' => GradeLevel::where('id', $this->grade_level_id)->first()->name,
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
        ]);
    }
}
