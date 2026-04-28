<?php

namespace App\Livewire\Teacher;

use App\Models\AcademicYear;
use App\Models\AttendanceRecord;
use App\Models\Section;
use App\Models\StudentRecord;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class AttendanceSection extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    public $section_id;

    public $selected_academic_year_id;

    public function mount()
    {
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                StudentRecord::query()
                    ->where('is_active', true)
                    ->where('academic_year_id', $this->selected_academic_year_id)
                    ->when($this->section_id, function ($query) {
                        $query->where('section_id', $this->section_id);
                    })->orderBy('lastname', 'asc')
            )
            ->columns([
                TextColumn::make('student')
                    ->label('STUDENT NAME')
                    ->formatStateUsing(
                        fn($record) => strtoupper($record->student->lastname . ', ' . $record->student->firstname . ' ' . ($record->student->middlename ? substr($record->student->middlename, 0, 1) . '.' : ''))
                    )
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student.lrn')
                    ->label('LRN')
                    ->sortable(),
                TextColumn::make('section.name')
                    ->label('SECTION')
                    ->formatStateUsing(fn($record) => strtoupper($record->section->name))
                    ->sortable(),
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
            ->actions([])
            ->bulkActions([
                BulkAction::make('present')
                    ->color('success')
                    ->icon('heroicon-o-document-check')
                    ->label('Mark as Present')
                    ->requiresConfirmation()
                    ->modalHeading('Mark Attendance')
                    ->modalDescription('Are you sure you want to mark the selected students as present?')
                    ->modalSubmitActionLabel('Yes, Mark Present')
                    ->action(function (Collection $records) {
                        $alreadyPresent = [];
                        $addedAttendance = [];
                        $activeYearId = AcademicYear::getActiveYearId();

                        foreach ($records as $record) {
                            $existingAttendance = AttendanceRecord::where('student_record_id', $record->id)
                                ->whereDate('created_at', now()->toDateString())
                                ->exists();

                            if ($existingAttendance) {
                                $alreadyPresent[] = strtoupper($record->student->lastname . ', ' . $record->student->firstname);
                            } else {
                                AttendanceRecord::create([
                                    'student_record_id' => $record->id,
                                    'academic_year_id' => $activeYearId,
                                ]);
                                $addedAttendance[] = strtoupper($record->student->lastname . ', ' . $record->student->firstname);
                            }
                        }

                        $messages = [];
                        if (! empty($alreadyPresent)) {
                            $messages[] = count($alreadyPresent) . ' student(s) already marked present: ' . implode(', ', $alreadyPresent);
                        }
                        if (! empty($addedAttendance)) {
                            $messages[] = count($addedAttendance) . ' student(s) marked present: ' . implode(', ', $addedAttendance);
                        }

                        session()->flash('attendance_message', implode(' | ', $messages));
                        $this->resetTable();
                    }),
            ])
            ->emptyStateHeading('No Students Found')
            ->emptyStateDescription('Select a section to view students.');
    }

    public function updatedSectionId()
    {
        $this->resetTable();
    }

    public function render(): View
    {
        return view('livewire.teacher.attendance-section', [
            'sections' => Section::where('staff_id', auth()->user()->staff->id)
                ->get(),
            'academic_years' => AcademicYear::orderByDesc('is_active')->orderBy('name', 'desc')->get(),
        ]);
    }
}
