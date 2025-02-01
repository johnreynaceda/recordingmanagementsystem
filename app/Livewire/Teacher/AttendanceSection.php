<?php

namespace App\Livewire\Teacher;

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
use Flasher\SweetAlert\Prime\SweetAlertInterface;

class AttendanceSection extends Component implements HasForms, HasTable
{
    use InteractsWithTable, InteractsWithForms;

    public $section_id;

    /**
     * Configures the table to display students for the selected section.
     */
    public function table(Table $table): Table
    {
        return $table
            ->query(
                StudentRecord::query()
                    ->where('is_active', true)
                    ->when($this->section_id, function ($query) {
                        // Apply the section filter
                        $query->where('section_id', $this->section_id);
                    })
            )
            ->columns([
                TextColumn::make('student')
                    ->label('STUDENT NAME')
                    ->formatStateUsing(
                        fn($record) => strtoupper($record->student->firstname . ' ' . $record->student->lastname)
                    )
                    ->searchable(),
                TextColumn::make('section.name')
                    ->label('SECTION')->formatStateUsing(
                        fn($record) => strtoupper($record->section->name)
                    )
            ])
            ->filters([
                // SelectFilter::make('section_id')
                //     ->label('Sections')
                //     ->options(
                //         Section::where('staff_id', auth()->user()->staff->id)
                //             ->pluck('name', 'id') // Fetching section names and ids
                //             ->toArray()
                //     ),
            ])
            ->actions([])
            ->bulkActions([
                BulkAction::make('present')
                    ->color('success')
                    ->icon('heroicon-o-document-check')
                    ->label('Present Student')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        $alreadyPresent = [];
                        $addedAttendance = [];
                
                        foreach ($records as $record) {
                            $existingAttendance = AttendanceRecord::where('student_record_id', $record->id)
                                ->whereDate('created_at', now()->toDateString())
                                ->exists();
                
                            if ($existingAttendance) {
                                $alreadyPresent[] = strtoupper($record->student->firstname. ' '. $record->student->lastname); // Assuming 'name' exists in the $record
                            } else {
                                AttendanceRecord::create([
                                    'student_record_id' => $record->id,
                                ]);
                                $addedAttendance[] = strtoupper($record->student->firstname. ' '. $record->student->lastname); // Track newly added attendance
                            }
                        }
                
                        if (!empty($alreadyPresent)) {
                            $names = implode(', ', $alreadyPresent);
                            sweetalert()->info("The following students already have attendance: $names");
                        }
                
                        if (!empty($addedAttendance)) {
                            sweetalert()->success('Attendance record added successfully.');
                        }
                
                        return redirect()->route('teacher.attendance');
                    }),
                
            ])
            ->emptyStateHeading('No Students Found')
            ->emptyStateDescription('Please select a section to view students.');
    }

    /**
     * Watches for changes to section_id and updates the table accordingly.
     */
    public function updatedSectionId()
    {
        $this->resetTable(); // Reset and refresh the table when section_id changes
    }

    /**
     * Render the component view.
     */
    public function render(): View
    {
        return view('livewire.teacher.attendance-section', [
            'sections' => Section::where('staff_id', auth()->user()->staff->id)->get(),
        ]);
    }
}
