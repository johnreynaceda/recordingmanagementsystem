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
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Livewire\Component;

class Record extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected function getFormSchema(): array
    {
        return [
            Fieldset::make('Record Information')->schema([
                TextInput::make('firstname')->required(),
                TextInput::make('middlename'),
                TextInput::make('lastname')->required(),
                DatePicker::make('birthdate')->required(),
                TextInput::make('address')->required(),
                TextInput::make('contact_number')
                    ->label('Contact Number')
                    ->tel()
                    ->prefix('+63')
                    ->placeholder('917-123-4567')
                    ->helperText('Format: 917-123-4567')
                    ->mask('999-999-9999')
                    ->maxLength(12)
                    ->formatStateUsing(fn ($state): string => self::formatContactNumber($state))
                    ->dehydrateStateUsing(fn ($state): ?string => self::normalizeContactNumber($state))
                    ->rules(['regex:/^\d{3}-\d{3}-\d{4}$/'])
                    ->validationMessages([
                        'regex' => 'The contact number must use the format 917-123-4567.',
                    ])
                    ->extraInputAttributes([
                        'inputmode' => 'numeric',
                        'pattern' => '[0-9]{3}-[0-9]{3}-[0-9]{4}',
                    ])
                    ->nullable(),
                TextInput::make('lrn')
                    ->label('LRN')
                    ->placeholder('12-digit LRN')
                    ->length(12)
                    ->rules(['digits:12'])
                    ->extraInputAttributes([
                        'inputmode' => 'numeric',
                        'pattern' => '[0-9]{12}',
                    ])
                    ->nullable(),
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
                    ->slideOver()
                    ->successNotification(null)
                    ->after(fn () => sweetalert()->success('Record created successfully!')),
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
                        'danger' => fn ($state) => in_array($state, ['dropped', 'inactive']),
                        'primary' => fn ($state) => in_array($state, ['graduated', 'transfer in', 'transfer out']),
                    ]),
            ])
            ->filters([
                SelectFilter::make('grade_level')
                    ->options(RecordModel::query()->distinct()->pluck('grade_level', 'grade_level')->filter()->toArray())
                    ->searchable(),
                SelectFilter::make('section')
                    ->options(RecordModel::query()->distinct()->pluck('section', 'section')->filter()->toArray())
                    ->searchable(),
                SelectFilter::make('academic_year')
                    ->options(RecordModel::query()->distinct()->pluck('academic_year', 'academic_year')->filter()->toArray())
                    ->searchable(),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->actions([
                ActionGroup::make([
                    ViewAction::make()->form($this->getFormSchema()),
                    EditAction::make()
                        ->form($this->getFormSchema())
                        ->successNotification(null)
                        ->after(fn () => sweetalert()->success('Record updated successfully!')),
                    Action::make('change_status')
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
                            sweetalert()->success('Record status updated successfully!');
                        }),
                    DeleteAction::make()
                        ->successNotification(null)
                        ->after(fn () => sweetalert()->success('Record deleted successfully!')),
                ]),
            ])
            ->bulkActions([
                //
            ]);
    }

    public function render()
    {
        return view('livewire.admin.record');
    }

    private static function formatContactNumber(?string $number): string
    {
        $localNumber = self::localContactNumber($number);

        if (! $localNumber || strlen($localNumber) !== 10) {
            return $localNumber ?? '';
        }

        return substr($localNumber, 0, 3).'-'.substr($localNumber, 3, 3).'-'.substr($localNumber, 6, 4);
    }

    private static function normalizeContactNumber(?string $number): ?string
    {
        $localNumber = self::localContactNumber($number);

        return filled($localNumber) ? '+63'.$localNumber : null;
    }

    private static function localContactNumber(?string $number): ?string
    {
        if (! filled($number)) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $number);

        if (str_starts_with($digits, '63') && strlen($digits) === 12) {
            return substr($digits, 2);
        }

        if (str_starts_with($digits, '0') && strlen($digits) === 11) {
            return substr($digits, 1);
        }

        return $digits;
    }
}
