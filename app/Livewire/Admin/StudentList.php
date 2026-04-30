<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Student;
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
                            $this->applyStudentRecordConstraints($query, $this->studentRecordFilters());
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
                    ->iconPosition(IconPosition::After)
                    ->url(fn(): string => route('admin.students-create')),
            ])
            ->columns([
                Grid::make(1)
                    ->schema([
                        ViewColumn::make('firstname')
                            ->searchable(['firstname', 'middlename', 'lastname', 'lrn'])
                            ->view('filament.tables.student'),
                    ]),
            ])
            ->contentGrid([
                'md' => 3,
                '2xl' => 4,
            ])
            ->searchPlaceholder('Search name or LRN')
            ->filters([
                SelectFilter::make('academic_year_id')
                    ->label('Academic Year')
                    ->options(AcademicYear::pluck('name', 'id')->toArray())
                    ->default($this->selected_academic_year_id)
                    ->query(function ($query, array $data) {
                        $this->applyStudentRecordFilters($query, [
                            'academic_year_id' => $data['value'] ?? null,
                        ]);
                    }),
                SelectFilter::make('grade_level_id')
                    ->label('Grade Level')
                    ->options(GradeLevel::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->query(function ($query, array $data) {
                        $this->applyStudentRecordFilters($query, [
                            'grade_level_id' => $data['value'] ?? null,
                        ]);
                    }),
                SelectFilter::make('section_id')
                    ->label('Section')
                    ->options(Section::orderBy('name')->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->query(function ($query, array $data) {
                        $this->applyStudentRecordFilters($query, [
                            'section_id' => $data['value'] ?? null,
                        ]);
                    }),
            ])
            ->actions([
                EditAction::make('edit')
                    ->color('success')
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
                    ]),
                DeleteAction::make('delete'),

                ActionGroup::make([
                    Action::make('view')->label('View Record')->icon('heroicon-o-viewfinder-circle')->color('success')->url(fn(Student $record): string => route('admin.students-record', $record))
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
                        ->url(fn(Student $record): string => route('admin.student-grades', $record->id)),
                ])->color('black'),
            ])
            ->bulkActions([
                // Add bulk actions if needed
            ])
            ->emptyStateHeading('No Student yet')
            ->emptyStateDescription('Once you add the first student, it will appear here.');
    }

    public function render()
    {
        return view('livewire.admin.student-list', [
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
        ]);
    }
}
