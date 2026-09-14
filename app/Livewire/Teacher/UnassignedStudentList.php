<?php

namespace App\Livewire\Teacher;

use App\Models\AcademicYear;
use App\Models\StudentRecord;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class UnassignedStudentList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public ?int $academicYearId = null;

    public function mount(): void
    {
        abort_unless(auth()->user()?->user_type === 'teacher', 403);

        $this->academicYearId = AcademicYear::getActiveYearId();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->unassignedQuery())
            ->columns([
                TextColumn::make('student.lastname')
                    ->label('Student')
                    ->formatStateUsing(fn (StudentRecord $record): string => strtoupper(
                        $record->student->lastname.', '.$record->student->firstname.' '.$record->student->middlename
                    ))
                    ->description(fn (StudentRecord $record): string => $record->student->user?->email ?? 'No email address')
                    ->searchable(query: fn (Builder $query, string $search): Builder => $query->whereHas(
                        'student',
                        fn (Builder $studentQuery): Builder => $studentQuery
                            ->where('firstname', 'like', "%{$search}%")
                            ->orWhere('middlename', 'like', "%{$search}%")
                            ->orWhere('lastname', 'like', "%{$search}%")
                    )),
                TextColumn::make('student.lrn')
                    ->label('LRN')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('student.contact_number')
                    ->label('Contact Number')
                    ->placeholder('Not provided'),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->since()
                    ->dateTimeTooltip(),
            ])
            ->actions([
                Action::make('proceed_registration')
                    ->label('Proceed')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->url(fn (StudentRecord $record): string => route('teacher.students-create', [
                        'student_record' => $record->id,
                    ])),
                Action::make('reject_registration')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject student registration?')
                    ->modalDescription('The student will not be able to access the portal. Their registration will be retained for reference.')
                    ->modalSubmitActionLabel('Reject registration')
                    ->action(function (StudentRecord $record): void {
                        $record->student->update(['status' => 'Rejected']);
                        $record->update(['is_active' => false]);

                        sweetalert()->success('Student registration rejected.');
                    }),
            ])
            ->emptyStateIcon('heroicon-o-user-group')
            ->emptyStateHeading('No unassigned students')
            ->emptyStateDescription('New self-registrations that need a grade level and section will appear here.')
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }

    public function render()
    {
        return view('livewire.teacher.unassigned-student-list', [
            'unassignedCount' => $this->unassignedQuery()->count(),
        ]);
    }

    private function unassignedQuery(): Builder
    {
        return StudentRecord::query()
            ->with(['student.user', 'academicYear'])
            ->when(filled($this->academicYearId), fn (Builder $query) => $query->where('academic_year_id', $this->academicYearId))
            ->where(function (Builder $query) {
                $query->whereNull('grade_level_id')
                    ->orWhereNull('section_id');
            })
            ->whereHas('student', fn (Builder $query) => $query->where(function (Builder $statusQuery) {
                $statusQuery->whereNull('status')
                    ->orWhere('status', '!=', 'Rejected');
            }))
            ->latest();
    }
}
