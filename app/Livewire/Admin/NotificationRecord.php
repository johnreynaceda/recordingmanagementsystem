<?php

namespace App\Livewire\Admin;

use App\Models\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class NotificationRecord extends Component  implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Notification::query()->orderByDesc(''))
            ->columns([
                TextColumn::make('student.id')->label('Student Name')->formatStateUsing(
                    fn($state) => $state ? $state : 'N/A'
                )->getStateUsing(function (Notification $record) {
                    return $record->student ? $record->student->user->name : 'N/A';
                }),

                TextColumn::make('message')->label('Message'),
                TextColumn::make('is_read')->label('Status')->badge()->color(fn(string $state): string => match ($state) {
                    '1' => 'success',
                    '0' => 'warning',
                })->formatStateUsing(fn(string $state): string => match ($state) {
                    '1' => 'Read',
                    '0' => 'Unread',
                }),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.admin.notification-record');
    }
}
