<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentRecord;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Livewire\Component;

class StudentList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public $selected_academic_year_id;

    public function mount()
    {
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
    }

    private function studentRecordFilters(array $overrides = []): array
    {
        $filters = [
            'academic_year_id' => $this->getTableFilterState('academic_year_id')['value'] ?? $this->selected_academic_year_id,
            'grade_level_id' => $this->getTableFilterState('grade_level_id')['value'] ?? null,
            'section_id' => $this->getTableFilterState('section_id')['value'] ?? null,
        ];

        foreach ($overrides as $key => $value) {
            $filters[$key] = $value;
        }

        return $filters;
    }

    private function applyStudentRecordConstraints($query, array $filters)
    {
        return $query
            ->when(filled($filters['academic_year_id']), function ($query) use ($filters) {
                $query->where('academic_year_id', $filters['academic_year_id']);
            })
            ->when(filled($filters['grade_level_id']), function ($query) use ($filters) {
                $query->where('grade_level_id', $filters['grade_level_id']);
            })
            ->when(filled($filters['section_id']), function ($query) use ($filters) {
                $query->where('section_id', $filters['section_id']);
            });
    }

    private function applyStudentRecordFilters(Builder $query, array $overrides = []): Builder
    {
        $filters = $this->studentRecordFilters($overrides);

        return $query->whereHas('studentRecords', function (Builder $query) use ($filters) {
            $this->applyStudentRecordConstraints($query, $filters);
        });
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Student::query()
                    ->with([
                        'studentRecords' => function ($query) {
                            $this->applyStudentRecordConstraints($query, $this->studentRecordFilters())
                                ->latest('id');
                        },
                        'studentRecords.gradeLevel',
                        'studentRecords.section',
                        'studentRecords.academicYear',
                    ])
                    ->orderBy('lastname', 'asc')
            )
            ->headerActions([
                Action::make('student')
                    ->label('New Student')
                    ->icon('heroicon-o-user-plus')
                    ->iconPosition(IconPosition::Before)
                    ->color('danger')
                    ->url(fn (): string => route('admin.students-create')),
            ])
            ->columns([
                Grid::make(1)
                    ->schema([
                        ViewColumn::make('firstname')
                            ->searchable(query: function (Builder $query, string $search): Builder {
                                $search = '%'.str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $search).'%';

                                return $query->where(function (Builder $query) use ($search) {
                                    $query
                                        ->where('firstname', 'like', $search)
                                        ->orWhere('middlename', 'like', $search)
                                        ->orWhere('lastname', 'like', $search)
                                        ->orWhere('lrn', 'like', $search)
                                        ->orWhereHas('studentRecords', function (Builder $query) use ($search) {
                                            $this->applyStudentRecordConstraints($query, $this->studentRecordFilters())
                                                ->whereHas('section', function (Builder $query) use ($search) {
                                                    $query->where('name', 'like', $search);
                                                });
                                        });
                                });
                            })
                            ->view('filament.tables.student'),
                    ]),
            ])
            ->contentGrid([
                'sm' => 2,
                'xl' => 3,
                '2xl' => 4,
            ])
            ->searchPlaceholder('Search students by name, LRN, or section')
            ->filters([
                SelectFilter::make('academic_year_id')
                    ->label('Academic Year')
                    ->placeholder('Select school year')
                    ->options(fn (): array => AcademicYear::orderByDesc('is_active')
                        ->orderBy('name', 'desc')
                        ->pluck('name', 'id')
                        ->toArray())
                    ->default($this->selected_academic_year_id)
                    ->selectablePlaceholder(false)
                    ->searchable()
                    ->preload()
                    ->query(function (Builder $query, array $data): Builder {
                        return $this->applyStudentRecordFilters($query, [
                            'academic_year_id' => $data['value'] ?? $this->selected_academic_year_id,
                        ]);
                    }),
                SelectFilter::make('grade_level_id')
                    ->label('Grade Level')
                    ->placeholder('All grade levels')
                    ->options(fn (): array => GradeLevel::whereHas('studentRecords', function (Builder $query) {
                        $this->applyStudentRecordConstraints($query, [
                            'academic_year_id' => $this->studentRecordFilters()['academic_year_id'],
                            'grade_level_id' => null,
                            'section_id' => null,
                        ]);
                    })
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->toArray())
                    ->searchable()
                    ->preload()
                    ->query(function (Builder $query, array $data): Builder {
                        return $this->applyStudentRecordFilters($query, [
                            'grade_level_id' => $data['value'] ?? null,
                        ]);
                    }),
                SelectFilter::make('section_id')
                    ->label('Section')
                    ->placeholder('All sections')
                    ->options(fn (): array => Section::whereHas('studentRecords', function (Builder $query) {
                        $this->applyStudentRecordConstraints($query, [
                            'academic_year_id' => $this->studentRecordFilters()['academic_year_id'],
                            'grade_level_id' => null,
                            'section_id' => null,
                        ]);
                    })
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->toArray())
                    ->searchable()
                    ->preload()
                    ->query(function (Builder $query, array $data): Builder {
                        return $this->applyStudentRecordFilters($query, [
                            'section_id' => $data['value'] ?? null,
                        ]);
                    }),
                SelectFilter::make('placement_status')
                    ->label('Placement Status')
                    ->placeholder('All students')
                    ->options([
                        'unassigned' => 'Needs placement',
                        'assigned' => 'Assigned',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $status = $data['value'] ?? null;

                        if (! in_array($status, ['unassigned', 'assigned'], true)) {
                            return $query;
                        }

                        if ($status === 'unassigned') {
                            $query->where(function (Builder $statusQuery) {
                                $statusQuery->whereNull('status')
                                    ->orWhere('status', '!=', 'Rejected');
                            });
                        }

                        return $query->whereHas('studentRecords', function (Builder $recordQuery) use ($status) {
                            $this->applyStudentRecordConstraints($recordQuery, $this->studentRecordFilters());

                            $recordQuery->where(function (Builder $placementQuery) use ($status) {
                                if ($status === 'unassigned') {
                                    $placementQuery
                                        ->whereNull('grade_level_id')
                                        ->orWhereNull('section_id');

                                    return;
                                }

                                $placementQuery
                                    ->whereNotNull('grade_level_id')
                                    ->whereNotNull('section_id');
                            });
                        });
                    }),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->filtersTriggerAction(fn (Action $action): Action => $action->button()->icon(null))
            ->filtersFormColumns([
                'default' => 1,
                'md' => 4,
            ])
            ->persistFiltersInSession()
            ->actions([
                Action::make('proceed_registration')
                    ->label('Proceed')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Student $record): bool => $this->needsPlacement($record))
                    ->url(fn (Student $record): string => route('admin.students-create', [
                        'student_record' => $this->placementRecord($record)?->id,
                    ])),
                Action::make('reject_registration')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject student registration?')
                    ->modalDescription('The student will not be able to access the portal. Their registration record will be retained for reference.')
                    ->modalSubmitActionLabel('Reject registration')
                    ->visible(fn (Student $record): bool => $this->needsPlacement($record))
                    ->action(function (Student $record): void {
                        $record->update(['status' => 'Rejected']);
                        $this->placementRecord($record)?->update(['is_active' => false]);

                        sweetalert()->success('Student registration rejected.');
                    }),
                EditAction::make('edit')
                    ->label('Edit Info')
                    ->icon('heroicon-o-pencil-square')
                    ->color('success')
                    ->successNotification(null)
                    ->mutateRecordDataUsing(function (array $data, Student $record): array {
                        $data['email'] = $record->user?->email;

                        return $data;
                    })
                    ->using(function (Student $record, array $data): Student {
                        $email = $data['email'];
                        unset($data['email'], $data['age']);

                        $record->update($data);
                        $record->user?->update([
                            'name' => $record->firstname.' '.$record->lastname,
                            'email' => $email,
                        ]);

                        sweetalert()->success('Student information updated successfully!');

                        return $record;
                    })
                    ->form([
                        Fieldset::make("STUDENT'S INFORMATION")->schema([
                            TextInput::make('firstname')->required(),
                            TextInput::make('middlename'),
                            TextInput::make('lastname')->required(),
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->rules(fn (Student $record): array => [
                                    Rule::unique('users', 'email')->ignore($record->user_id),
                                ]),
                            DatePicker::make('birthdate')->required(),
                            TextInput::make('contact_number')->required(),
                            TextInput::make('age')->required()->disabled()->formatStateUsing(function ($state, $record) {
                                if (! $record?->birthdate) {
                                    return null;
                                }

                                return Carbon::parse($record->birthdate)->age;
                            }),
                            TextInput::make('address')->required()->columnSpan(2),
                        ])->columns(3),
                    ])
                    ->visible(fn (Student $record): bool => ! $this->needsPlacement($record)),
                // DeleteAction::make('delete')
                //     ->icon('heroicon-o-trash'),

                ActionGroup::make([
                    Action::make('view')->label('View Record')->icon('heroicon-o-viewfinder-circle')->color('success')->url(fn (Student $record): string => route('admin.students-record', $record))
                        ->openUrlInNewTab(),
                    Action::make('change')->label('Change Password')->icon('heroicon-m-key')->form([
                        TextInput::make('password')->password()->required()->revealable(),
                    ])->modalWidth('lg')->action(function ($record, $data) {
                        $record->user->update([
                            'password' => bcrypt($data['password']),
                        ]);
                        sweetalert()->success('Password changed successfully!');
                    }),
                    Action::make('grade')
                        ->label('View Grades')
                        ->icon('heroicon-o-document-chart-bar')
                        ->color('info')
                        ->url(fn (Student $record): string => route('admin.student-grades', $record->id)),
                    Action::make('attendance')
                        ->label('View Attendance')
                        ->icon('heroicon-o-document-chart-bar')
                        ->color('info')
                        ->url(fn (Student $record): string => route('admin.student-attendance', $record->id)),
                    // ActionGroup::make([
                    //     Action::make('attendance_report')
                    //         ->label('Attendance Report')
                    //         ->icon('heroicon-o-calendar-days')
                    //         ->color('info')
                    //         ->url(fn (Student $record): string => route('admin.student-attendance', [
                    //             'student' => $record,
                    //             'academic_year_id' => $this->studentRecordFilters()['academic_year_id'],
                    //         ])),
                    //     ActionGroup::make([
                    //         Action::make('attendance_pdf')
                    //             ->label('Export as PDF')
                    //             ->icon('heroicon-o-document-arrow-down')
                    //             ->color('danger')
                    //             ->url(fn (Student $record): string => route('admin.student-attendance.export', [
                    //                 'student' => $record,
                    //                 'format' => 'pdf',
                    //                 'academic_year_id' => $this->studentRecordFilters()['academic_year_id'],
                    //             ]))
                    //             ->openUrlInNewTab(),
                    //         Action::make('attendance_excel')
                    //             ->label('Export as Excel')
                    //             ->icon('heroicon-o-table-cells')
                    //             ->color('success')
                    //             ->url(fn (Student $record): string => route('admin.student-attendance.export', [
                    //                 'student' => $record,
                    //                 'format' => 'excel',
                    //                 'academic_year_id' => $this->studentRecordFilters()['academic_year_id'],
                    //             ]))
                    //             ->openUrlInNewTab(),
                    //     ])
                    //         ->label('Export Attendance')
                    //         ->icon('heroicon-o-arrow-down-tray')
                    //         ->dropdownWidth('sm'),
                    // ])
                    //     ->label('View Attendance')
                    //     ->icon('heroicon-o-clipboard-document-check')
                    //     ->dropdownWidth('sm'),
                ])
                    ->label('More')
                    ->icon('heroicon-o-ellipsis-horizontal-circle')
                    ->color('gray')
                    ->visible(fn (Student $record): bool => ! $this->needsPlacement($record)),
            ])
            ->bulkActions([
                // Add bulk actions if needed
            ])
            ->emptyStateIcon('heroicon-o-academic-cap')
            ->emptyStateHeading('No students found')
            ->emptyStateDescription('Add a student or adjust the filters to see matching records.')
            ->emptyStateActions([
                Action::make('create_student')
                    ->label('New Student')
                    ->icon('heroicon-o-user-plus')
                    ->color('danger')
                    ->url(fn (): string => route('admin.students-create')),
            ]);
    }

    public function render()
    {
        $academicYearId = $this->studentRecordFilters()['academic_year_id'];
        $studentsForAcademicYear = fn (): Builder => Student::query()
            ->when(filled($academicYearId), fn (Builder $query) => $query->whereHas(
                'studentRecords',
                fn (Builder $query) => $query->where('academic_year_id', $academicYearId)
            ));

        return view('livewire.admin.student-list', [
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
            'total_students' => $studentsForAcademicYear()->count(),
            'active_students' => $studentsForAcademicYear()->where(function (Builder $query) {
                $query->whereNull('status')
                    ->orWhereNotIn('status', ['Graduated', 'Rejected']);
            })->count(),
            'graduated_students' => $studentsForAcademicYear()->where('status', 'Graduated')->count(),
            'unassigned_students' => StudentRecord::query()
                ->when(filled($academicYearId), fn (Builder $query) => $query->where('academic_year_id', $academicYearId))
                ->whereHas('student', fn (Builder $query) => $query->where(function (Builder $statusQuery) {
                    $statusQuery->whereNull('status')
                        ->orWhere('status', '!=', 'Rejected');
                }))
                ->where(function (Builder $query) {
                    $query->whereNull('grade_level_id')
                        ->orWhereNull('section_id');
                })
                ->distinct('student_id')
                ->count('student_id'),
        ]);
    }

    private function placementRecord(Student $student): ?StudentRecord
    {
        $academicYearId = $this->studentRecordFilters()['academic_year_id'];

        return $student->studentRecords()
            ->when(filled($academicYearId), fn (Builder $query) => $query->where('academic_year_id', $academicYearId))
            ->orderByDesc('is_active')
            ->latest('id')
            ->first();
    }

    private function needsPlacement(Student $student): bool
    {
        if (in_array($student->status, ['Graduated', 'Rejected'], true)) {
            return false;
        }

        $record = $this->placementRecord($student);

        return $record !== null && (! $record->grade_level_id || ! $record->section_id);
    }
}
