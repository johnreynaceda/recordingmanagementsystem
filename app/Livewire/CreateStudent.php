<?php

namespace App\Livewire;

use App\Models\GradeLevel;
use App\Models\Post;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentRecord;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;
use Livewire\Component;

class CreateStudent extends Component implements HasForms
{
    use InteractsWithForms;

    public $firstname, $lastname, $middlename, $birthdate, $address, $grade_level, $email, $section, $student_picture = [], $lrn, $contact_number;
    public $password, $confirm_password;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make("STUDENT'S INFORMATION")->schema([
                    FileUpload::make('student_picture'),
                    ViewField::make('rating')
                        ->view('filament.forms.blank')->columnSpan(2),
                    TextInput::make('firstname')->label('First Name')->required()->live()
                        ->afterStateUpdated(
                            fn($state, callable $set) =>
                            $set('firstname', ucfirst(strtolower($state)))
                        ),
                    TextInput::make('middlename')->label('Middle Name')->live()
                        ->afterStateUpdated(
                            fn($state, callable $set) =>
                            $set('middlename', ucfirst(strtolower($state)))
                        ),
                    TextInput::make('lastname')->label('Last Name')->required()->live()
                        ->afterStateUpdated(
                            fn($state, callable $set) =>
                            $set('lastname', ucfirst(strtolower($state)))
                        ),
                    DatePicker::make('birthdate')->required()->reactive(),
                    Textinput::make('contact_number')->required(),
                    TextInput::make('address')->required()->columnSpan(2),
                    Select::make('grade_level')->options(
                        GradeLevel::all()->pluck('name', 'id')
                    )->live()->searchable()->required(),
                    Select::make('section')->options(Section::where('grade_level_id', $this->grade_level)->get()->pluck('name', 'id'))->required()

                ])->columns(3),
                Fieldset::make("STUDENT'S ACCOUNT")->schema([
                    TextInput::make('lrn')->label('LRN')->required(),
                    TextInput::make('email')->email()->required(),
                    TextInput::make('password')->password()->required()->revealable(),
                    TextInput::make('confirm_password')->same('password')->password()->required()->revealable(),


                ])->columns(3)
            ]);
    }

    public function submitRecord()
    {
        $this->validate([
            'firstname' => ['required', 'string', 'max:50'],
            'middlename' => ['nullable', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'birthdate' => ['required', 'date'],
            'address' => ['required', 'string', 'max:100'],
            'grade_level' => ['required'],
            'section' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required'],
            'confirm_password' => ['required', 'same:password'],
            'student_picture' => ['required'],
            'lrn' => ['required', 'string', 'max:50'],
            'contact_number' => ['required', 'string', 'max:20'],
        ]);


        $user = User::create([
            'name' => $this->firstname . ' ' . $this->lastname,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'user_type' => 'student',
        ]);

        foreach ($this->student_picture as $key => $value) {
            $student = Student::create([
                'firstname' => $this->firstname,
                'middlename' => $this->middlename,
                'lastname' => $this->lastname,
                'birthdate' => $this->birthdate,
                'address' => $this->address,
                'contact_number' => $this->contact_number,
                'lrn' => $this->lrn,
                'image_path' => $value->store('Student Profile', 'public'),
                'user_id' => $user->id
            ]);

            StudentRecord::create([
                'student_id' => $student->id,
                'grade_level_id' => $this->grade_level,
                'section_id' => $this->section,
                'is_active' => true,
            ]);
        }
        Password::sendResetLink([
            'email' => $user->email,
        ]);
        return redirect()->route('admin.students');
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
