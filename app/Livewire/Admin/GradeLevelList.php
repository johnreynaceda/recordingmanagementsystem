<?php

namespace App\Livewire\Admin;

use App\Models\GradeLevel;
use App\Models\Staff;
use App\Models\User;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
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
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(GradeLevel::query())->headerActions([
               CreateAction::make('new_grade_level')->label('New Grade level')->icon('heroicon-o-plus')->iconPosition(IconPosition::After)->form([
                TextInput::make('name')->required()
               ])->modalWidth('xl')->modalHeading('Create Grade Level')
            ])
            ->columns([
               
                TextColumn::make('name')->label('NAME'),
             
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('sections')->label('Manage Section')->button()->icon('heroicon-o-arrow-right')->iconPosition(IconPosition::After)->url(fn (GradeLevel $record): string => route('admin.section', $record)),
               EditAction::make('edit')->color('success')->action(
                function($record, $data){
                    $record->update([
                        'firstname' => $data['firstname'],
                        'lastname' => $data['lastname'],
                       'middlename' => $data['middlename'],
                       'address' => $data['address'],
                    ]);
                    $record->user->update([
                        'email' => $data['email'],
                        'password' => $data['password'] ? bcrypt($data['password']) : '',
                    ]);
                }
               )->form([
                TextInput::make('name')->required()
               ])->modalWidth('xl')->modalHeading('Edit Grade Level'),
               DeleteAction::make('delete'),
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
