<?php

namespace App\Livewire\Admin;

use App\Models\GradeLevel;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class GradeLevelList extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(GradeLevel::query())->headerActions([
                CreateAction::make('new_grade_level')->label('New Grade level')->icon('heroicon-o-plus')->iconPosition(IconPosition::After)->form([
                    TextInput::make('name')->required(),
                ])->modalWidth('xl')->modalHeading('Create Grade Level')
                    ->successNotification(null)
                    ->after(fn () => sweetalert()->success('Grade level created successfully!')),
            ])
            ->columns([

                TextColumn::make('name')->label('NAME'),

            ])
            ->actions([
                EditAction::make('edit')->color('success')->action(
                    function ($record, $data) {
                        $record->update([
                            'name' => $data['name'],
                        ]);
                        sweetalert()->success('Grade level updated successfully!');
                    }
                )->form([
                    TextInput::make('name')->required(),
                ])->modalWidth('xl')->modalHeading('Edit Grade Level')
                    ->successNotification(null),
                DeleteAction::make('delete')
                    ->successNotification(null)
                    ->after(fn () => sweetalert()->success('Grade level deleted successfully!')),
                ActionGroup::make([
                Action::make('sections')->label('Manage Section')->color('danger')->icon('heroicon-o-arrow-right')->url(fn (GradeLevel $record): string => route('admin.section', $record)),
                Action::make('subjects')->label('Assign Subjects')->color('success')->icon('heroicon-o-folder-plus')->url(fn (GradeLevel $record): string => route('admin.grade-level-subjects', $record)),
                ])->color('black'),
            ])
            ->bulkActions([
                // ...
            ])->emptyStateHeading('No Grade Level yet')->emptyStateDescription('Once you add the first grade level, it will appear here.');
    }

    public function render()
    {
        return view('livewire.admin.grade-level-list');
    }
}
