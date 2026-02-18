<?php

namespace App\Livewire\Admin;

use App\Models\Student;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

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
                'md'  => 3,
                '2xl' => 4,
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                EditAction::make('edit')->color('success')->form([
                    Fieldset::make("STUDENT'S INFORMATION")->schema([

                        TextInput::make('firstname')->required(),
                        TextInput::make('middlename'),
                        TextInput::make('lastname')->required(),
                        DatePicker::make('birthdate')->required(),
                        TextInput::make('contact_number')->required(),

                        TextInput::make('age')->required()->disabled()->formatStateUsing(function ($state, $record) {
                            if (! $record?->birthdate) {
                                return null;
                            }

                            return Carbon::parse($record->birthdate)->age;
                        }),
                        TextInput::make('address')->required()->columnSpan(2),

                    ])->columns(3),

                ]),
                DeleteAction::make('delete'),
                Action::make('grade')
                    ->label('Grades')
                    ->badge()
                    ->color('info')
                    ->url(function ($record) {
                        $grade = $record->studentGrades->first();
                        return $grade ? Storage::url($grade->file_path) : null;
                    })
                    ->openUrlInNewTab()
                    ->visible(
                        fn($record) =>
                        optional($record->studentGrades->first())->file_path
                    ),
                ActionGroup::make([
                    Action::make('view')->label('View Record')->icon('heroicon-o-viewfinder-circle')->color('success')->url(fn(Student $record): string => route('admin.students-record', $record))
                        ->openUrlInNewTab(),
                    Action::make('change')->label('Change Password')->icon('heroicon-m-key')->form([
                        TextInput::make('password')->password()->required()->revealable(),
                    ])->modalWidth('lg')->action(function ($record, $data) {
                        $record->user->update([
                            'password' => bcrypt($data['password'])
                        ]);

                        sweetalert()->success('Password changed successfully!');
                    }),
                ])->color('black'),
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
