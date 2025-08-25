<?php

namespace App\Livewire\Admin;

use App\Models\Staff;
use Livewire\Component;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class StaffRecord extends Component implements HasForms, HasTable
{
     use InteractsWithTable;
    use InteractsWithForms;

      public function table(Table $table): Table
    {
        return $table
            ->query(Staff::query())->headerActions([
                CreateAction::make('create')->form([
                    TextInput::make('sd')
                ])
            ])
            ->columns([
                TextColumn::make('id')->label('FULLNAME')->formatStateUsing(
                    fn($record) => $record->firstname. ' ' . $record->lastname
                )->searchable(['firstname', 'lastname']),
                TextColumn::make('user.email')->label('EMAIL'),
                TextColumn::make('address')->label('ADDRESS'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
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
               )->form(
                function($record){
                   
                    return [
                        Fieldset::make('INFORMATION')->schema([
                            TextInput::make('firstname')->required(),
                            TextInput::make('middlename'),
                            TextInput::make('lastname')->required(),
                            TextInput::make('address')->columnSpan(2),
                        ]),
                        Fieldset::make('ACCOUNT')->schema([
                            TextInput::make('email')->email()->afterStateHydrated(function ($state, callable $set) use ($record) {
                                $set('email', $record->user->email);
                            }),
                            TextInput::make('password')->password(),
                        ]),
                    ];
                }
               ),
               DeleteAction::make('delete'),
            ])
            ->bulkActions([
                // ...
            ])->emptyStateHeading('No Staff yet')->emptyStateDescription('Once you add the first staff, it will appear here.');
    }


    public function render()
    {
        return view('livewire.admin.staff-record');
    }
}
