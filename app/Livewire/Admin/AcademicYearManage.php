<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class AcademicYearManage extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->unique('academic_years', 'name', ignoreRecord: true)
                ->placeholder('2024-2025'),
            DatePicker::make('start_date')->required(),
            DatePicker::make('end_date')->required(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(AcademicYear::query()->orderByDesc('is_active')->orderBy('name', 'desc'))
            ->headerActions([
                CreateAction::make()
                    ->form($this->getFormSchema())
                    ->modalWidth('lg')
                    ->slideOver(),
            ])
            ->columns([
                TextColumn::make('name')->label('Academic Year')->searchable(),
                TextColumn::make('start_date')->label('Start Date')->date('M d, Y'),
                TextColumn::make('end_date')->label('End Date')->date('M d, Y'),
                BadgeColumn::make('is_active')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn($state) => $state ? 'success' : 'gray'),
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    ViewAction::make()->form($this->getFormSchema()),
                    EditAction::make()->form($this->getFormSchema()),
                    \Filament\Tables\Actions\Action::make('set_active')
                        ->label('Set as Active')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn(AcademicYear $record) => !$record->is_active)
                        ->action(function (AcademicYear $record): void {
                            $record->setAsActive();
                            \Filament\Notifications\Notification::make()
                                ->title('Academic Year activated')
                                ->success()
                                ->send();
                        }),
                    DeleteAction::make(),
                ]),
            ]);
    }

    public function render()
    {
        return view('livewire.admin.academic-year');
    }
}
