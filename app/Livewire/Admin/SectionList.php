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
use Filament\Tables\Table;
use Livewire\Component;

class SectionList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public $grade_level_id;

    public $active_academic_year_id;

    public function mount()
    {
        $this->grade_level_id = request('id');
        $this->active_academic_year_id = AcademicYear::getActiveYearId();
    }

    private function teacherOptions(): array
    {
        return Staff::with('user')->get()->mapWithKeys(function ($staff) {
            return [$staff->id => $staff->firstname.' '.$staff->lastname];
        })->toArray();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Section::query()
                    ->where('grade_level_id', $this->grade_level_id)
                    ->when(
                        filled($this->active_academic_year_id),
                        fn ($query) => $query->where('academic_year_id', $this->active_academic_year_id),
                        fn ($query) => $query->whereRaw('1 = 0'),
                    )
            )
            ->headerActions([
                CreateAction::make('section')
                    ->label('New Section')
                    ->icon('heroicon-o-plus')
                    ->iconPosition(IconPosition::After)
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['grade_level_id'] = $this->grade_level_id;
                        $data['academic_year_id'] = $this->active_academic_year_id;

                        return $data;
                    })
                    ->form([
                        TextInput::make('name')->required(),
                    ])
                    ->visible(fn (): bool => filled($this->active_academic_year_id))
                    ->modalWidth('xl')
                    ->modalHeading('Create Section')
                    ->successNotification(null)
                    ->after(fn () => sweetalert()->success('Section created successfully!')),
            ])
            ->columns([
                TextColumn::make('name')->label('NAME'),
                TextColumn::make('academicYear.name')
                    ->label('SCHOOL YEAR')
                    ->placeholder('Legacy section'),
                TextColumn::make('staff')
                    ->label('TEACHER')
                    ->formatStateUsing(fn ($record) => $record->staff ? $record->staff->firstname.' '.$record->staff->lastname : 'Not Assigned'),
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
                        sweetalert()->success('Teacher assigned successfully!');
                    })
                    ->form([
                        Select::make('staff')
                            ->label('Teacher')
                            ->options($this->teacherOptions())
                            ->searchable()
                            ->required(),
                    ])
                    ->modalWidth('xl')
                    ->visible(fn ($record) => $record->staff_id == null || $record->staff == null),
                EditAction::make('edit')
                    ->color('success')
                    ->action(function ($record, $data) {
                        $record->update([
                            'name' => $data['name'],
                            'staff_id' => $data['staff_id'] ?? null,
                            'academic_year_id' => $data['academic_year_id'],
                        ]);
                        sweetalert()->success('Section updated successfully!');
                    })
                    ->form([
                        TextInput::make('name')->required(),
                        Select::make('academic_year_id')
                            ->label('School Year')
                            ->options(AcademicYear::orderByDesc('start_date')->pluck('name', 'id'))
                            ->required(),
                        Select::make('staff_id')
                            ->label('Teacher')
                            ->options($this->teacherOptions())
                            ->searchable()
                            ->placeholder('Select a teacher')
                            ->nullable(),
                    ])
                    ->modalWidth('xl')
                    ->modalHeading('Edit Section')
                    ->successNotification(null),
                DeleteAction::make('delete')
                    ->successNotification(null)
                    ->after(fn () => sweetalert()->success('Section deleted successfully!')),
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
        ]);
    }
}
