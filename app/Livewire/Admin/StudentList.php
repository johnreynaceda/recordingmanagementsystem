<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\ViewColumn;

class StudentList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Student::query())
            ->headerActions([
                Action::make('student')
                    ->label('New Student')
                    ->icon('heroicon-o-user-plus')
                    ->iconPosition(IconPosition::After)
                    ->url(fn(): string => route('admin.students-create')),
            ])
            ->columns([
                Grid::make(1) // Define the number of columns in the grid
                    ->schema([
                        ViewColumn::make('firstname')
                            ->view('filament.tables.student'), // Ensure the view path is correct
                        // Add more columns if needed, like:
                        
                    ]),
            ])
            ->contentGrid([
                'md' => 3,
                '2xl' => 4,
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
               EditAction::make('edit')->color('success'),
               DeleteAction::make('delete'),
               ActionGroup::make([
               
                EditAction::make(),
                DeleteAction::make(),
            ]),
            ])
            ->bulkActions([
                // Add bulk actions if needed
            ])
            ->emptyStateHeading('No Student yet')
            ->emptyStateDescription('Once you add the first student, it will appear here.');
    }

    public function render()
    {
        return view('livewire.admin.student-list');
    }
}
