<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Models\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use App\Notifications\RequestApprovedNotification;
use Livewire\Component;

class Request extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $selected_academic_year_id;

    public function mount()
    {
        $this->selected_academic_year_id = AcademicYear::getActiveYearId();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\request::query()
                ->where('academic_year_id', $this->selected_academic_year_id)
                ->orderByDesc('created_at'))
            ->columns([
                TextColumn::make('name')->label('NAME')->searchable(),
                TextColumn::make('email_address')->label('EMAIL')->searchable(),
                TextColumn::make('phone_number')->label('PHONE NUMBER')->searchable(),
                TextColumn::make('option')->label('FORM')->searchable(),
                TextColumn::make('additional_information')->words(3)->label('ADDITIONAL INFO')->searchable(),
                TextColumn::make('academicYear.name')->label('ACADEMIC YEAR')->searchable(),
                TextColumn::make('created_at')->label('REQUESTED AT')->date(),
                TextColumn::make('status')->label('STATUS')->badge()->color(fn(string $state): string => match ($state) {
                    'approved' => 'success',
                    'declined' => 'danger',
                }),
            ])
            ->filters([
                SelectFilter::make('academic_year_id')
                    ->label('Academic Year')
                    ->options(AcademicYear::pluck('name', 'id')->toArray())
                    ->default($this->selected_academic_year_id)
                    ->query(function ($query, array $data) {
                        if (filled($data['value'])) {
                            $query->where('academic_year_id', $data['value']);
                        }
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('approve')->color('success')->icon('heroicon-s-hand-thumb-up')->action(
                        function ($record) {
                            $record->user->notify(new RequestApprovedNotification('Form ' . $record->option));
                            $record->update(['status' => 'approved']);
                        }
                    ),
                    Action::make('Decline')->color('danger')->icon('heroicon-s-hand-thumb-down')->action(
                        fn($record) => $record->update(['status' => 'declined'])
                    ),
                ])->hidden(fn($record) => $record->status != null)
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        $notif = Notification::where('is_read', 0)->get();
        $notif->each->update(['is_read' => 1]);

        return view('livewire.admin.request');
    }
}
