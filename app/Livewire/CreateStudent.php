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
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Arr;
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

    public $student_picture = [];

    public $lrn;

    public $contact_number;

    public $password;

    public $confirm_password;

    public $sectionOptions = [];

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
                    TextInput::make('contact_number')->required(),
                    TextInput::make('address')->required()->columnSpan(2),
                    Select::make('grade_level')
                        ->options(GradeLevel::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state) {
                            $this->sectionOptions = Section::where('grade_level_id', $state)->pluck('name', 'id')->toArray();
                            $this->section = null;
                        }),
                    Select::make('section')
                        ->options(fn () => $this->sectionOptions)
                        ->required()
                        ->reactive(),

                ])->columns(3),
                Fieldset::make("STUDENT'S ACCOUNT")->schema([
                    TextInput::make('lrn')->label('LRN')->required(),
                    TextInput::make('email')->email()->required(),
                    TextInput::make('password')
                        ->password()
                        ->required()
                        ->maxLength(self::MAX_PASSWORD_LENGTH)
                        ->revealable(),
                    TextInput::make('confirm_password')
                        ->same('password')
                        ->password()
                        ->required()
                        ->maxLength(self::MAX_PASSWORD_LENGTH)
                        ->revealable(),

                ])->columns(3),
            ]);
    }

    public function submitRecord()
    {
        $this->firstname = $this->normalizeName($this->firstname);
        $this->middlename = $this->normalizeName($this->middlename);
        $this->lastname = $this->normalizeName($this->lastname);

        $this->validate([
            'firstname' => ['required', 'string', 'max:50'],
            'middlename' => ['nullable', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'birthdate' => ['required', 'date'],
            'address' => ['required', 'string', 'max:100'],
            'grade_level' => ['required'],
            'section' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'max:'.self::MAX_PASSWORD_LENGTH],
            'confirm_password' => ['required', 'string', 'max:'.self::MAX_PASSWORD_LENGTH, 'same:password'],
            'student_picture' => ['nullable'],
            'student_picture.*' => ['image', 'max:'.self::MAX_PROFILE_IMAGE_SIZE_KB],
            'lrn' => ['required', 'string', 'max:50'],
            'contact_number' => ['required', 'string', 'max:20'],
        ]);

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
            'contact_number' => $this->contact_number,
            'lrn' => $this->lrn,
            'image_path' => $imagePath,
            'user_id' => $user->id,
        ]);

        StudentRecord::create([
            'student_id' => $student->id,
            'grade_level_id' => $this->grade_level,
            'section_id' => $this->section,
            'is_active' => true,
            'academic_year_id' => AcademicYear::getActiveYearId(),
        ]);

        try {
            Password::sendResetLink([
                'email' => $user->email,
            ]);
        } catch (\Exception $e) {
            \Log::warning('Password reset email failed: '.$e->getMessage());
        }

        return redirect()->route('admin.students');
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
        return view('livewire.create-student');
    }
}
