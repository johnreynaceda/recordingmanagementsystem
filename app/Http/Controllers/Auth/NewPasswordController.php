<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $isStudentPasswordReset = false;

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request, &$isStudentPasswordReset) {
                $isStudentPasswordReset = $user->user_type === 'student';

                if (
                    $user->user_type === 'student'
                    && $user->password_changed_at === null
                    && Hash::check($request->password, $user->password)
                ) {
                    throw ValidationException::withMessages([
                        'password' => 'The new password must be different from your initial password.',
                    ]);
                }

                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'password_changed_at' => $user->user_type === 'student'
                        ? now()
                        : $user->password_changed_at,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        $loginRoute = $isStudentPasswordReset ? 'student-login' : 'login';

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route($loginRoute)->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
