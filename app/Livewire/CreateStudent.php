<?php

namespace App\Livewire;

use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateStudent extends Component implements HasForms
{
    use InteractsWithForms;

    private const MAX_PROFILE_IMAGE_SIZE_KB = 2048;

    private const MAX_PASSWORD_LENGTH = 16;

    public $firstname;

    public $lastname;

    public $middlename;

    public $birthdate;

    public $address;

    public $grade_level;

    public $email;

    public $section;

    public $selected_academic_year_id;

    public $student_picture = [];

    public $lrn;

    public $contact_number;

    public $parent_name;

    public $parent_contact;

    public $password;

    public $confirm_password;

    public $sectionOptions = [];

    public ?int $student_record_id = null;

    public ?int $existing_student_id = null;

    public ?int $existing_user_id = null;

    public bool $isCompletingRegistration = false;

    public function mount(): void
    {
        abort_unless(in_array(auth()->user()?->user_type, ['admin', 'teacher'], true), 403);

        $this->selected_academic_year_id = AcademicYear::getActiveYearId()
            ?? AcademicYear::latest('start_date')->value('id');

        $recordId = request()->integer('student_record');

        if (! $recordId) {
            return;
        }

        $record = StudentRecord::query()
            ->with('student.user')
            ->findOrFail($recordId);

        abort_if(
            $record->student->status === 'Rejected'
                || (filled($record->grade_level_id) && filled($record->section_id)),
            409,
            'This student registration can no longer be processed.'
        );

        $student = $record->student;

        $this->student_record_id = $record->id;
        $this->existing_student_id = $student->id;
        $this->existing_user_id = $student->user_id;
        $this->isCompletingRegistration = true;
        $this->firstname = $student->firstname;
        $this->middlename = $student->middlename;
        $this->lastname = $student->lastname;
        $this->birthdate = $student->birthdate;
        $this->address = $student->address;
        $this->contact_number = $this->localContactNumber($student->contact_number);
        $this->parent_name = $student->parent_name;
        $this->parent_contact = $this->localContactNumber($student->parent_contact);
        $this->lrn = $student->lrn;
        $this->email = $student->user?->email;
        $this->grade_level = $record->grade_level_id;
        $this->section = $record->section_id;
        $this->selected_academic_year_id = $record->academic_year_id ?? $this->selected_academic_year_id;
        $this->loadSectionOptions();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make("STUDENT'S INFORMATION")->schema([
                    FileUpload::make('student_picture')
                        ->multiple(false)
                        ->image()
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                        ->maxSize(self::MAX_PROFILE_IMAGE_SIZE_KB),
                    ViewField::make('rating')
                        ->view('filament.forms.blank')->columnSpan(2),
                    TextInput::make('firstname')->label('First Name')->required()->live()
                        ->afterStateUpdated(
                            fn ($state, callable $set) => $set('firstname', $this->capitalizeNameWhileTyping($state))
                        ),
                    TextInput::make('middlename')->label('Middle Name')->live()
                        ->afterStateUpdated(
                            fn ($state, callable $set) => $set('middlename', $this->capitalizeNameWhileTyping($state))
                        ),
                    TextInput::make('lastname')->label('Last Name')->required()->live()
                        ->afterStateUpdated(
                            fn ($state, callable $set) => $set('lastname', $this->capitalizeNameWhileTyping($state))
                        ),
                    DatePicker::make('birthdate')->required()->reactive(),
                    TextInput::make('contact_number')
                        ->label('Contact Number')
                        ->tel()
                        ->prefix('+63')
                        ->placeholder('917-123-4567')
                        ->helperText('Format: 917-123-4567')
                        ->mask('999-999-9999')
                        ->maxLength(12)
                        ->rules(['digits:10'])
                        ->extraInputAttributes([
                            'inputmode' => 'numeric',
                            'pattern' => '[0-9]{3}-[0-9]{3}-[0-9]{4}',
                        ])
                        ->required(),
                    TextInput::make('address')->required()->columnSpan(2),
                    Select::make('selected_academic_year_id')
                        ->label('School Year')
                        ->options(AcademicYear::orderByDesc('is_active')->orderByDesc('start_date')->pluck('name', 'id'))
                        ->required()
                        ->searchable()
                        ->reactive()
                        ->afterStateUpdated(function () {
                            $this->section = null;
                            $this->loadSectionOptions();
                        }),
                    Select::make('grade_level')
                        ->options(GradeLevel::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function () {
                            $this->loadSectionOptions();
                            $this->section = null;
                        }),
                    Select::make('section')
                        ->options(fn () => $this->sectionOptions)
                        ->required()
                        ->reactive(),

                ])->columns(3),
                Fieldset::make("PARENT/GUARDIAN'S INFORMATION")->schema([
                    TextInput::make('parent_name')
                        ->label('Full Name')
                        ->placeholder("Enter the parent or guardian's full name")
                        ->maxLength(100)
                        ->live()
                        ->afterStateUpdated(
                            fn ($state, callable $set) => $set('parent_name', $this->capitalizeNameWhileTyping($state))
                        ),
                    TextInput::make('parent_contact')
                        ->label('Contact Number')
                        ->tel()
                        ->prefix('+63')
                        ->placeholder('917-123-4567')
                        ->helperText('Format: 917-123-4567')
                        ->mask('999-999-9999')
                        ->maxLength(12)
                        ->rules(['nullable', 'digits:10'])
                        ->extraInputAttributes([
                            'inputmode' => 'numeric',
                            'pattern' => '[0-9]{3}-[0-9]{3}-[0-9]{4}',
                        ]),
                ])->columns(2),
                Fieldset::make("STUDENT'S ACCOUNT")->schema([
                    TextInput::make('lrn')
                        ->label('LRN')
                        ->placeholder('12-digit LRN')
                        ->length(12)
                        ->rules(['digits:12'])
                        ->extraInputAttributes([
                            'inputmode' => 'numeric',
                            'pattern' => '[0-9]*',
                            'maxlength' => '12',
                            'oninput' => "this.value = this.value.replace(/\\D/g, '').slice(0, 12)",
                        ])
                        ->required(),
                    TextInput::make('email')->email()->required(),
                    TextInput::make('password')
                        ->password()
                        ->required(fn (): bool => ! $this->isCompletingRegistration)
                        ->helperText(fn (): ?string => $this->isCompletingRegistration ? 'Leave blank to keep the student\'s current password.' : null)
                        ->maxLength(self::MAX_PASSWORD_LENGTH)
                        ->revealable(),
                    TextInput::make('confirm_password')
                        ->same('password')
                        ->password()
                        ->required(fn (): bool => ! $this->isCompletingRegistration)
                        ->maxLength(self::MAX_PASSWORD_LENGTH)
                        ->revealable(),

                ])->columns(3),
            ]);
    }

    public function submitRecord(bool $createAnother = false)
    {
        abort_unless(in_array(auth()->user()?->user_type, ['admin', 'teacher'], true), 403);

        $this->firstname = $this->normalizeName($this->firstname);
        $this->middlename = $this->normalizeName($this->middlename);
        $this->lastname = $this->normalizeName($this->lastname);
        $this->parent_name = $this->normalizeName($this->parent_name);
        $this->contact_number = $this->localContactNumber($this->contact_number);
        $this->parent_contact = $this->localContactNumber($this->parent_contact);

        $passwordRules = $this->isCompletingRegistration
            ? ['nullable', 'string', 'max:'.self::MAX_PASSWORD_LENGTH]
            : ['required', 'string', 'max:'.self::MAX_PASSWORD_LENGTH];
        $confirmationRules = $this->isCompletingRegistration
            ? ['nullable', 'string', 'max:'.self::MAX_PASSWORD_LENGTH, 'same:password']
            : ['required', 'string', 'max:'.self::MAX_PASSWORD_LENGTH, 'same:password'];

        $this->validate([
            'firstname' => ['required', 'string', 'max:50'],
            'middlename' => ['nullable', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'birthdate' => ['required', 'date'],
            'address' => ['required', 'string', 'max:100'],
            'selected_academic_year_id' => ['required', 'exists:academic_years,id'],
            'grade_level' => ['required', 'exists:grade_levels,id'],
            'section' => [
                'required',
                Rule::exists('sections', 'id')->where(function ($query) {
                    $query->where('grade_level_id', $this->grade_level)
                        ->where(function ($query) {
                            $query->where('academic_year_id', $this->selected_academic_year_id)
                                ->orWhereNull('academic_year_id');
                        });
                }),
            ],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->existing_user_id)],
            'password' => $passwordRules,
            'confirm_password' => $confirmationRules,
            'student_picture' => ['nullable'],
            'student_picture.*' => ['image', 'max:'.self::MAX_PROFILE_IMAGE_SIZE_KB],
            'lrn' => ['required', 'digits:12', Rule::unique('students', 'lrn')->ignore($this->existing_student_id)],
            'contact_number' => ['required', 'digits:10'],
            'parent_name' => ['nullable', 'string', 'max:100'],
            'parent_contact' => ['nullable', 'digits:10'],
        ], [
            'lrn.digits' => 'The LRN must contain exactly 12 digits.',
            'contact_number.digits' => 'The contact number must contain exactly 10 digits after +63.',
            'parent_contact.digits' => 'The parent or guardian contact number must contain exactly 10 digits after +63.',
        ]);

        if ($this->isCompletingRegistration) {
            return $this->completeRegistration();
        }

        $user = User::create([
            'name' => $this->firstname.' '.$this->lastname,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'user_type' => 'student',
        ]);

        $uploadedImage = Arr::first($this->student_picture);

        $imagePath = $uploadedImage
            ? $uploadedImage->store('Student Profile', 'public')
            : null;

        $student = Student::create([
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'birthdate' => $this->birthdate,
            'address' => $this->address,
            'contact_number' => '+63'.$this->contact_number,
            'parent_name' => $this->parent_name,
            'parent_contact' => filled($this->parent_contact) ? '+63'.$this->parent_contact : null,
            'lrn' => $this->lrn,
            'image_path' => $imagePath,
            'user_id' => $user->id,
        ]);

        StudentRecord::create([
            'student_id' => $student->id,
            'grade_level_id' => $this->grade_level,
            'section_id' => $this->section,
            'is_active' => true,
            'academic_year_id' => $this->selected_academic_year_id,
        ]);

        if ($createAnother) {
            $this->resetForm();

            sweetalert()->success('Student created successfully! You can now add another student.');
            session()->flash('success', 'Student created successfully. You can now add another student.');

            return null;
        }

        sweetalert()->success('Student account created successfully!');

        return redirect()->to($this->returnUrl());
    }

    private function resetForm(): void
    {
        $this->reset([
            'firstname',
            'lastname',
            'middlename',
            'birthdate',
            'address',
            'grade_level',
            'email',
            'section',
            'student_picture',
            'lrn',
            'contact_number',
            'parent_name',
            'parent_contact',
            'password',
            'confirm_password',
            'sectionOptions',
        ]);

        $this->selected_academic_year_id = AcademicYear::getActiveYearId()
            ?? AcademicYear::latest('start_date')->value('id');
        $this->student_picture = [];
        $this->sectionOptions = [];

        $this->resetValidation();
    }

    private function normalizeName(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = preg_replace('/\s+/', ' ', trim($value));

        return $value === '' ? null : ucwords(strtolower($value));
    }

    private function capitalizeNameWhileTyping(?string $value): string
    {
        return ucwords(strtolower($value ?? ''));
    }

    public function updatedBirthdate($value)
    {
        $this->birthdate = $value;

        if ($value) {
            $age = Carbon::parse($value)->age;

            if ($age < 12) {
                $this->addError('birthdate', 'Age must be at least 12 years old.');
                $this->birthdate = null; // optional: reset invalid value
            } else {
                $this->resetErrorBag('birthdate');
            }
        }
    }

    public function render()
    {
        return view('livewire.create-student', [
            'returnUrl' => $this->returnUrl(),
            'returnLabel' => auth()->user()?->user_type === 'teacher' ? 'Back to dashboard' : 'Back to list',
        ]);
    }

    private function returnUrl(): string
    {
        return auth()->user()?->user_type === 'teacher'
            ? route('teacher.dashboard')
            : route('admin.students');
    }

    private function completeRegistration(): mixed
    {
        $record = StudentRecord::query()
            ->with('student.user')
            ->findOrFail($this->student_record_id);
        $student = $record->student;
        $uploadedImage = Arr::first($this->student_picture);

        $studentData = [
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'birthdate' => $this->birthdate,
            'address' => $this->address,
            'contact_number' => '+63'.$this->contact_number,
            'parent_name' => $this->parent_name,
            'parent_contact' => filled($this->parent_contact) ? '+63'.$this->parent_contact : null,
            'lrn' => $this->lrn,
            'status' => null,
        ];

        if ($uploadedImage) {
            $studentData['image_path'] = $uploadedImage->store('Student Profile', 'public');
        }

        $student->update($studentData);

        $userData = [
            'name' => $this->firstname.' '.$this->lastname,
            'email' => $this->email,
        ];

        if (filled($this->password)) {
            $userData['password'] = bcrypt($this->password);
        }

        $student->user->update($userData);
        $record->update([
            'grade_level_id' => $this->grade_level,
            'section_id' => $this->section,
            'academic_year_id' => $this->selected_academic_year_id,
            'is_active' => true,
        ]);

        sweetalert()->success('Student registration approved and completed!');

        return redirect()->to($this->returnUrl());
    }

    private function localContactNumber(?string $number): ?string
    {
        if (! filled($number)) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $number);

        return str_starts_with($digits, '63') && strlen($digits) === 12
            ? substr($digits, 2)
            : $digits;
    }

    private function loadSectionOptions(): void
    {
        if (! filled($this->grade_level) || ! filled($this->selected_academic_year_id)) {
            $this->sectionOptions = [];

            return;
        }

        $this->sectionOptions = Section::query()
            ->where('grade_level_id', $this->grade_level)
            ->forAcademicYear($this->selected_academic_year_id)
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }
}
