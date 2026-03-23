<?php

namespace App\Livewire\Admin;

use App\Models\Announcement;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class AnnouncementList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(Announcement::query()->latest())
            ->headerActions([
                CreateAction::make('create')
                    ->label('New Announcement')
                    ->icon('heroicon-o-plus')
                    ->iconPosition(IconPosition::After)
                    ->form([
                        TextInput::make('title')->required(),
                        Textarea::make('content')->required()->rows(4),
                        FileUpload::make('image')
                            ->image()
                            ->directory('announcements')
                            ->maxSize(2048),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->modalWidth('xl')
                    ->modalHeading('Create Announcement'),
            ])
            ->columns([
                TextColumn::make('title')->label('TITLE')->searchable()->sortable(),
                ImageColumn::make('image')->label('IMAGE'),
                IconColumn::make('is_active')
                    ->label('STATUS')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                TextColumn::make('created_at')->label('DATE CREATED')->dateTime('F d, Y')->sortable(),
            ])
            ->actions([
                EditAction::make('edit')
                    ->color('success')
                    ->form([
                        TextInput::make('title')->required(),
                        Textarea::make('content')->required()->rows(4),
                        FileUpload::make('image')
                            ->image()
                            ->directory('announcements')
                            ->maxSize(2048),
                        Toggle::make('is_active')
                            ->label('Active'),
                    ])
                    ->modalWidth('xl')
                    ->modalHeading('Edit Announcement'),
                DeleteAction::make('delete'),
            ])
            ->emptyStateHeading('No Announcements yet')
            ->emptyStateDescription('Create a new announcement to see it listed here.');
    }

    public function render()
    {
        return view('livewire.admin.announcement-list');
    }
}
