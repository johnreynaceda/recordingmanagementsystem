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
                        fn($record) => $record->student->firstname . ' ' . $record->student->lastname
                    )
                    ->searchable(),
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
                        // Handle marking the student as present
                       foreach ($records as $key => $value) {
                        AttendanceRecord::create([
                            'student_record_id' => $value->id
                        ]);
                       }
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
