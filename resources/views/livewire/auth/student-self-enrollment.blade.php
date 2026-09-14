@section('title', 'Student Registration')

<div class="px-1 py-2 sm:px-2">
    <a href="{{ route('student-login') }}"
        class="inline-flex items-center gap-2 rounded-md text-sm font-semibold text-slate-500 transition hover:text-main focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 0 1 1.06 1.06L5.56 9.25h10.69A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
        </svg>
        Back to student login
    </a>

    <div class="mt-5 overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 shadow-sm">
        <header class="relative overflow-hidden bg-slate-950 px-5 py-7 text-white sm:px-8 sm:py-9">
            <div class="absolute -right-16 -top-20 h-56 w-56 rounded-full bg-main/20 blur-3xl"></div>
            <div class="relative flex items-center gap-4">
                <div class="rounded-2xl bg-white p-2 shadow-lg">
                    <img class="h-14 w-14 object-contain sm:h-16 sm:w-16" src="{{ asset('images/tmcnhs_logo.png') }}" alt="TMCNHS logo">
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-red-200">Student Portal</p>
                    <h1 class="mt-1 text-2xl font-bold tracking-tight sm:text-3xl">Create your student account</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-300">Complete the form below to register for the student portal.</p>
                </div>
            </div>
        </header>

        <form wire:submit="enroll">
            <div class="space-y-6 p-4 sm:p-6 lg:p-8">
                <p class="text-sm text-slate-500"><span class="font-bold text-red-600">*</span> Required fields</p>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6" aria-labelledby="account-heading">
                    <div class="flex items-start gap-3 border-b border-slate-100 pb-4">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-50 text-sm font-bold text-main">1</span>
                        <div>
                            <h2 id="account-heading" class="text-lg font-bold text-slate-900">Account Information</h2>
                            <p class="mt-1 text-sm text-slate-500">Set up the credentials you will use to access the portal.</p>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="lrn" class="block text-sm font-semibold text-slate-700">LRN <span class="text-red-600">*</span></label>
                            <input id="lrn" type="text" wire:model="lrn" required inputmode="numeric" pattern="[0-9]*" maxlength="12" autocomplete="username"
                                oninput="this.value = this.value.replace(/\D/g, '').slice(0, 12)" placeholder="Enter your 12-digit LRN"
                                class="mt-2 block w-full rounded-xl border bg-white px-4 py-3 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-main focus:ring-main @error('lrn') border-red-400 @else border-slate-300 @enderror">
                            @error('lrn') <p class="mt-2 text-sm font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-700">Email Address <span class="text-red-600">*</span></label>
                            <input id="email" type="email" wire:model="email" required autocomplete="email" placeholder="student@example.com"
                                class="mt-2 block w-full rounded-xl border bg-white px-4 py-3 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-main focus:ring-main @error('email') border-red-400 @else border-slate-300 @enderror">
                            @error('email') <p class="mt-2 text-sm font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-semibold text-slate-700">Password <span class="text-red-600">*</span></label>
                            <input id="password" type="password" wire:model="password" required autocomplete="new-password" minlength="8" maxlength="16" placeholder="Create an 8–16 character password"
                                class="mt-2 block w-full rounded-xl border bg-white px-4 py-3 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-main focus:ring-main @error('password') border-red-400 @else border-slate-300 @enderror">
                            @error('password') <p class="mt-2 text-sm font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Confirm Password <span class="text-red-600">*</span></label>
                            <input id="password_confirmation" type="password" wire:model="password_confirmation" required autocomplete="new-password" minlength="8" maxlength="16" placeholder="Re-enter your password"
                                class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-main focus:ring-main">
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6" aria-labelledby="student-heading">
                    <div class="flex items-start gap-3 border-b border-slate-100 pb-4">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-50 text-sm font-bold text-main">2</span>
                        <div>
                            <h2 id="student-heading" class="text-lg font-bold text-slate-900">Student Information</h2>
                            <p class="mt-1 text-sm text-slate-500">Use the learner's information exactly as it appears in school records.</p>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        <div>
                            <label for="firstname" class="block text-sm font-semibold text-slate-700">First Name <span class="text-red-600">*</span></label>
                            <input id="firstname" type="text" wire:model="firstname" required autocomplete="given-name" maxlength="50" placeholder="Enter first name"
                                class="mt-2 block w-full rounded-xl border bg-white px-4 py-3 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-main focus:ring-main @error('firstname') border-red-400 @else border-slate-300 @enderror">
                            @error('firstname') <p class="mt-2 text-sm font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="middlename" class="block text-sm font-semibold text-slate-700">Middle Name <span class="font-normal text-slate-400">(Optional)</span></label>
                            <input id="middlename" type="text" wire:model="middlename" maxlength="50" placeholder="Enter middle name"
                                class="mt-2 block w-full rounded-xl border bg-white px-4 py-3 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-main focus:ring-main @error('middlename') border-red-400 @else border-slate-300 @enderror">
                            @error('middlename') <p class="mt-2 text-sm font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="lastname" class="block text-sm font-semibold text-slate-700">Last Name <span class="text-red-600">*</span></label>
                            <input id="lastname" type="text" wire:model="lastname" required autocomplete="family-name" maxlength="50" placeholder="Enter last name"
                                class="mt-2 block w-full rounded-xl border bg-white px-4 py-3 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-main focus:ring-main @error('lastname') border-red-400 @else border-slate-300 @enderror">
                            @error('lastname') <p class="mt-2 text-sm font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="birthdate" class="block text-sm font-semibold text-slate-700">Birthdate <span class="text-red-600">*</span></label>
                            <input id="birthdate" type="date" wire:model="birthdate" required max="{{ now()->subYears(12)->toDateString() }}"
                                class="mt-2 block w-full rounded-xl border bg-white px-4 py-3 text-sm shadow-sm transition focus:border-main focus:ring-main @error('birthdate') border-red-400 @else border-slate-300 @enderror">
                            @error('birthdate') <p class="mt-2 text-sm font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-slate-700">Address <span class="text-red-600">*</span></label>
                            <input id="address" type="text" wire:model="address" required autocomplete="street-address" maxlength="100" placeholder="House number, street, barangay, city"
                                class="mt-2 block w-full rounded-xl border bg-white px-4 py-3 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-main focus:ring-main @error('address') border-red-400 @else border-slate-300 @enderror">
                            @error('address') <p class="mt-2 text-sm font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2 lg:col-span-1">
                            <label for="contact_number" class="block text-sm font-semibold text-slate-700">Contact Number <span class="text-red-600">*</span></label>
                            <div class="mt-2 flex rounded-xl shadow-sm">
                                <span class="inline-flex items-center rounded-l-xl border border-r-0 border-slate-300 bg-slate-50 px-3 text-sm text-slate-500">+63</span>
                                <input id="contact_number" type="tel" wire:model="contact_number" required inputmode="numeric" pattern="[0-9]*" maxlength="10" autocomplete="tel" placeholder="9171234567"
                                    oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10)"
                                    class="block w-full rounded-r-xl border bg-white px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-main focus:ring-main @error('contact_number') border-red-400 @else border-slate-300 @enderror">
                            </div>
                            @error('contact_number') <p class="mt-2 text-sm font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6" aria-labelledby="guardian-heading">
                    <div class="flex items-start gap-3 border-b border-slate-100 pb-4">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-50 text-sm font-bold text-main">3</span>
                        <div>
                            <h2 id="guardian-heading" class="text-lg font-bold text-slate-900">Parent/Guardian Information</h2>
                            <p class="mt-1 text-sm text-slate-500">Provide a parent or guardian who can be contacted by the school.</p>
                        </div>
                    </div>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="parent_name" class="block text-sm font-semibold text-slate-700">Parent/Guardian Name <span class="text-red-600">*</span></label>
                            <input id="parent_name" type="text" wire:model="parent_name" required maxlength="100" placeholder="Enter parent or guardian's full name"
                                class="mt-2 block w-full rounded-xl border bg-white px-4 py-3 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-main focus:ring-main @error('parent_name') border-red-400 @else border-slate-300 @enderror">
                            @error('parent_name') <p class="mt-2 text-sm font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="parent_contact" class="block text-sm font-semibold text-slate-700">Parent/Guardian Contact Number <span class="text-red-600">*</span></label>
                            <div class="mt-2 flex rounded-xl shadow-sm">
                                <span class="inline-flex items-center rounded-l-xl border border-r-0 border-slate-300 bg-slate-50 px-3 text-sm text-slate-500">+63</span>
                                <input id="parent_contact" type="tel" wire:model="parent_contact" required inputmode="numeric" pattern="[0-9]*" maxlength="10" placeholder="9171234567"
                                    oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10)"
                                    class="block w-full rounded-r-xl border bg-white px-4 py-3 text-sm transition placeholder:text-slate-400 focus:border-main focus:ring-main @error('parent_contact') border-red-400 @else border-slate-300 @enderror">
                            </div>
                            @error('parent_contact') <p class="mt-2 text-sm font-medium text-red-600" role="alert">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>
            </div>

            <footer class="border-t border-slate-200 bg-white px-4 py-5 sm:px-6 lg:px-8">
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-center text-sm text-slate-500 sm:text-left">
                        Already registered?
                        <a href="{{ route('student-login') }}" class="font-semibold text-main hover:underline">Sign in</a>
                    </p>
                    <button type="submit" wire:loading.attr="disabled" wire:target="enroll"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-main px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto">
                        <svg wire:loading wire:target="enroll" class="mr-2 h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0A12 12 0 0 0 0 12h4Z" />
                        </svg>
                        <span wire:loading.remove wire:target="enroll">Create Account</span>
                        <span wire:loading wire:target="enroll">Creating account...</span>
                    </button>
                </div>
            </footer>
        </form>
    </div>
</div>
