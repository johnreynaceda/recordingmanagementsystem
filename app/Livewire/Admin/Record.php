<?php

namespace App\Livewire\Admin;

use App\Models\Record as RecordModel;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class Record extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected function getFormSchema(): array
    {
        return [
            Fieldset::make('Record Information')->schema([
                TextInput::make('firstname')->required(),
                TextInput::make('middlename'),
                TextInput::make('lastname')->required(),
                DatePicker::make('birthdate')->required(),
                TextInput::make('address')->required(),
                TextInput::make('contact_number')->nullable(),
                TextInput::make('lrn')->nullable(),
                FileUpload::make('image_path')->image()->label('Image')->columnSpanFull(),
            ])->columns(2),
            Fieldset::make('Academic Details')->schema([
                Select::make('status')->options([
                    'active' => 'Active',
                    'graduated' => 'Graduated',
                    'transfer in' => 'Transfer In',
                    'transfer out' => 'Transfer Out',
                    'dropped' => 'Dropped',
                    'LOA' => 'LOA',
                    'inactive' => 'Inactive',
                ])->required()->default('active'),
                TextInput::make('academic_year')->label('Academic Year'),
                TextInput::make('grade_level')->label('Grade Level'),
                TextInput::make('section')->label('Section'),
            ])->columns(2),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(RecordModel::query())
            ->headerActions([
            CreateAction::make()
            ->form($this->getFormSchema())
            ->modalWidth('2xl')
            ->slideOver(),
        ])
            ->columns([
            TextColumn::make('firstname')->label('First Name')->searchable(),
            TextColumn::make('lastname')->label('Last Name')->searchable(),
            TextColumn::make('lrn')->label('LRN')->searchable(),
            TextColumn::make('academic_year')->label('Academic Year')->searchable(),
            TextColumn::make('status')->label('Status')->badge()
            ->colors([
                'success' => 'active',
                'warning' => 'LOA',
                'danger' => fn($state) => in_array($state, ['dropped', 'inactive']),
                'primary' => fn($state) => in_array($state, ['graduated', 'transfer in', 'transfer out']),
            ]),
        ])
            ->filters([
            \Filament\Tables\Filters\SelectFilter::make('grade_level')
                ->options(RecordModel::query()->distinct()->pluck('grade_level', 'grade_level')->filter()->toArray())
                ->searchable(),
            \Filament\Tables\Filters\SelectFilter::make('section')
                ->options(RecordModel::query()->distinct()->pluck('section', 'section')->filter()->toArray())
                ->searchable(),
            \Filament\Tables\Filters\SelectFilter::make('academic_year')
                ->options(RecordModel::query()->distinct()->pluck('academic_year', 'academic_year')->filter()->toArray())
                ->searchable(),
        ])
            ->filtersLayout(\Filament\Tables\Enums\FiltersLayout::AboveContent)
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    ViewAction::make()->form($this->getFormSchema()),
                    EditAction::make()->form($this->getFormSchema()),
                    \Filament\Tables\Actions\Action::make('change_status')
                        ->label('Change Status')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->form([
                            Select::make('status')
                                ->options([
                                    'active' => 'Active',
                                    'graduated' => 'Graduated',
                                    'transfer in' => 'Transfer In',
                                    'transfer out' => 'Transfer Out',
                                    'dropped' => 'Dropped',
                                    'LOA' => 'LOA',
                                    'inactive' => 'Inactive',
                                ])
                                ->required(),
                        ])
                        ->action(function (RecordModel $record, array $data): void {
                            $record->update(['status' => $data['status']]);
                            \Filament\Notifications\Notification::make()
                                ->title('Status updated successfully')
                                ->success()
                                ->send();
                        }),
                    DeleteAction::make(),
                ])
            ])
            ->bulkActions([
            //
        ]);
    }

    public function render()
    {
        return view('livewire.admin.record');
    }
}
