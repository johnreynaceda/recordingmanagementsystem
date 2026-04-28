<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
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

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Student::query()
                    ->with(['studentRecords.gradeLevel', 'studentRecords.section', 'studentRecords.academicYear'])
                    ->whereHas('studentRecords', function ($query) {
                        $query->where('academic_year_id', $this->selected_academic_year_id);
                    })
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
                            ->view('filament.tables.student'),
                    ]),
            ])
            ->contentGrid([
                'md' => 3,
                '2xl' => 4,
            ])
            ->filters([
                SelectFilter::make('academic_year_id')
                    ->label('Academic Year')
                    ->options(AcademicYear::pluck('name', 'id')->toArray())
                    ->default($this->selected_academic_year_id)
                    ->query(function ($query, array $data) {
                        if (filled($data['value'])) {
                            $query->whereHas('studentRecords', function ($q) use ($data) {
                                $q->where('academic_year_id', $data['value']);
                            });
                        }
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
