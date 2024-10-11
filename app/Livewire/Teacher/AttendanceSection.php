<?php

namespace App\Livewire\Teacher;

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
                        $query->where('section_id', $this->section_id);
                    })
            )
            ->columns([
                TextColumn::make('student')->label('STUDENT NAME')->formatStateUsing(
                    fn($record) => $record->student->firstname . ' ' . $record->student->lastname
                )->searchable(),
            ])
            ->filters([
                // Filter for the section
                SelectFilter::make('section_id')->label('Sections')->options(Section::where('staff_id', auth()->user()->staff->id)->get()->pluck('name', 'id'))
            ])
            ->actions([])
            ->bulkActions([
                BulkAction::make('present')
                    ->color('success')
                    ->icon('heroicon-o-document-check')
                    ->label('Present Student')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        dd("Attendance.");
                    }),
            ])
            ->emptyStateHeading('No Students Found') // Optional: Custom message
            ->emptyStateDescription('Please select a section to view students.'); // Optional: Instructional message
    }
    

    /**
     * Render the component view.
     */
    public function render(): View
    {
        return view('livewire.teacher.attendance-section', [
            'sections' => auth()->user()->staff->sections,
        ]);
    }
}
