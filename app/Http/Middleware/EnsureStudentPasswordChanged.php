<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentPasswordChanged
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user?->user_type === 'student' && $user->password_changed_at === null) {
            $status = Password::sendResetLink(['email' => $user->email]);

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = $status === Password::RESET_LINK_SENT
                ? 'A password change link has been sent to your email address.'
                : __($status);

            return redirect()->route('student-login')->with(
                $status === Password::RESET_LINK_SENT ? 'status' : 'error',
                $message,
            );
        }

        return $next($request);
    }
}
