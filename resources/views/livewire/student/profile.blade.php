<div class="mx-auto max-w-7xl space-y-5 sm:space-y-6">
    @if (session()->has('success') || session('status') === 'password-updated')
        <div x-data="{ show: true }" x-show="show" x-transition.opacity
            class="flex items-start justify-between gap-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-emerald-800 shadow-sm"
            role="status">
            <div class="flex min-w-0 items-start gap-3">
                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-emerald-600 ring-1 ring-emerald-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm font-extrabold">{{ session('status') === 'password-updated' ? 'Password updated' : 'Profile updated' }}</p>
                    <p class="mt-0.5 text-sm font-medium text-emerald-700">
                        {{ session('status') === 'password-updated' ? 'Your account password was changed successfully.' : session('success') }}
                    </p>
                </div>
            </div>
            <button type="button" @click="show = false"
                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg transition hover:bg-emerald-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600"
                aria-label="Dismiss notification">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" />
                </svg>
            </button>
        </div>
    @endif

    @if (! $student)
        <section class="rounded-[20px] border border-dashed border-slate-300 bg-white px-6 py-14 text-center shadow-sm" aria-labelledby="profile-unavailable-title">
            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-[#a71930] ring-1 ring-red-100">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <circle cx="12" cy="8" r="3.75" />
                    <path stroke-linecap="round" d="M4.5 20a7.5 7.5 0 0 1 15 0" />
                </svg>
            </span>
            <h2 id="profile-unavailable-title" class="mt-5 text-xl font-extrabold tracking-tight text-[#101928]">Student profile unavailable</h2>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">We could not find a student record linked to this account. Please contact the school registrar for assistance.</p>
        </section>
    @elseif ($isEditing)
        <form wire:submit.prevent="save" class="overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#a71930]">Profile settings</p>
                    <h2 class="mt-1 text-xl font-extrabold tracking-[-0.025em] text-[#101928]">Edit personal information</h2>
                    <p class="mt-1 text-sm leading-6 text-slate-500">Keep your contact and family details accurate for school records.</p>
                </div>
                <span class="inline-flex w-fit items-center gap-2 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700 ring-1 ring-inset ring-amber-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500" aria-hidden="true"></span>
                    Unsaved changes
                </span>
            </div>

            <div class="grid lg:grid-cols-[280px_minmax(0,1fr)]">
                <aside class="border-b border-slate-200 bg-[#fdfcfb] p-5 sm:p-7 lg:border-b-0 lg:border-r" aria-label="Profile photo and academic information">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative">
                            <div class="h-32 w-32 overflow-hidden rounded-[24px] bg-slate-100 ring-4 ring-white shadow-md sm:h-36 sm:w-36">
                                @if ($new_image)
                                    <img src="{{ $new_image->temporaryUrl() }}" class="h-full w-full object-cover" alt="Preview of new profile photo">
                                @elseif ($student->image_path)
                                    <img src="{{ asset('storage/' . $student->image_path) }}" class="h-full w-full object-cover" alt="Profile photo of {{ trim($student->firstname . ' ' . $student->lastname) }}">
                                @else
                                    <span class="flex h-full w-full items-center justify-center bg-slate-100 text-slate-400">
                                        <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                            <circle cx="12" cy="8" r="3.75" />
                                            <path stroke-linecap="round" d="M4.5 20a7.5 7.5 0 0 1 15 0" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                            <label for="profile-photo"
                                class="absolute -bottom-2 -right-2 flex h-11 w-11 cursor-pointer items-center justify-center rounded-xl bg-[#a71930] text-white shadow-lg transition duration-300 hover:-translate-y-0.5 hover:bg-[#861326] focus-within:ring-2 focus-within:ring-[#b4233b] focus-within:ring-offset-2"
                                title="Choose a new profile photo">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 8.25h3l1.5-2.5h6l1.5 2.5h3A1.5 1.5 0 0 1 21 9.75v8.5a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 18.25v-8.5a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    <circle cx="12" cy="13" r="3" />
                                </svg>
                                <span class="sr-only">Choose a new profile photo</span>
                                <input id="profile-photo" type="file" wire:model="new_image" class="sr-only" accept="image/*">
                            </label>
                        </div>

                        <p class="mt-5 text-sm font-extrabold text-[#101928]">Profile photo</p>
                        <p class="mt-1 max-w-[210px] text-xs leading-5 text-slate-500">JPG or PNG, up to 2 MB. Use a clear, recent photo.</p>
                        <p wire:loading wire:target="new_image" class="mt-2 text-xs font-bold text-[#a71930]">Preparing preview...</p>
                        @if ($new_image)
                            <p class="mt-2 text-xs font-bold text-emerald-700">New photo selected</p>
                        @endif
                        @error('new_image')
                            <p class="mt-2 text-xs font-semibold leading-5 text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <dl class="mt-7 divide-y divide-slate-200 rounded-2xl border border-slate-200 bg-white px-4">
                        <div class="py-3.5">
                            <dt class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-slate-400">LRN</dt>
                            <dd class="mt-1 break-words text-sm font-extrabold text-[#101928]">{{ $student->lrn ?? 'N/A' }}</dd>
                        </div>
                        <div class="py-3.5">
                            <dt class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-slate-400">Grade &amp; section</dt>
                            <dd class="mt-1 text-sm font-extrabold text-[#a71930]">{{ $gradeLevel }} <span class="text-slate-300">/</span> {{ $section }}</dd>
                        </div>
                    </dl>
                </aside>

                <div class="p-5 sm:p-7 lg:p-8">
                    <section aria-labelledby="identity-heading">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#a71930] ring-1 ring-red-100">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.5" /><path stroke-linecap="round" d="M5 20a7 7 0 0 1 14 0" /></svg>
                            </span>
                            <div>
                                <h3 id="identity-heading" class="font-extrabold text-[#101928]">Identity details</h3>
                                <p class="text-xs text-slate-500">Enter your name as it appears on official records.</p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="firstname" class="block text-sm font-bold text-slate-700">First name <span class="text-[#a71930]">*</span></label>
                                <input id="firstname" type="text" wire:model="firstname" autocomplete="given-name"
                                    class="mt-2 block min-h-12 w-full rounded-xl border-slate-200 bg-[#fdfcfb] px-4 text-sm text-slate-800 shadow-sm transition focus:border-[#b4233b] focus:bg-white focus:ring-[#b4233b]">
                                @error('firstname') <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="middlename" class="block text-sm font-bold text-slate-700">Middle name <span class="font-medium text-slate-400">(optional)</span></label>
                                <input id="middlename" type="text" wire:model="middlename" autocomplete="additional-name"
                                    class="mt-2 block min-h-12 w-full rounded-xl border-slate-200 bg-[#fdfcfb] px-4 text-sm text-slate-800 shadow-sm transition focus:border-[#b4233b] focus:bg-white focus:ring-[#b4233b]">
                                @error('middlename') <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="lastname" class="block text-sm font-bold text-slate-700">Last name <span class="text-[#a71930]">*</span></label>
                                <input id="lastname" type="text" wire:model="lastname" autocomplete="family-name"
                                    class="mt-2 block min-h-12 w-full rounded-xl border-slate-200 bg-[#fdfcfb] px-4 text-sm text-slate-800 shadow-sm transition focus:border-[#b4233b] focus:bg-white focus:ring-[#b4233b]">
                                @error('lastname') <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="birthdate" class="block text-sm font-bold text-slate-700">Birthdate <span class="text-[#a71930]">*</span></label>
                                <input id="birthdate" type="date" wire:model="birthdate" autocomplete="bday"
                                    class="mt-2 block min-h-12 w-full rounded-xl border-slate-200 bg-[#fdfcfb] px-4 text-sm text-slate-800 shadow-sm transition focus:border-[#b4233b] focus:bg-white focus:ring-[#b4233b]">
                                @error('birthdate') <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </section>

                    <section class="mt-8 border-t border-slate-200 pt-7" aria-labelledby="contact-heading">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#a71930] ring-1 ring-red-100">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.25 3.75h2.2l1.25 4-2.1 1.55a13.2 13.2 0 0 0 6.1 6.1l1.55-2.1 4 1.25v2.2a3.5 3.5 0 0 1-3.5 3.5c-7.18 0-13-5.82-13-13a3.5 3.5 0 0 1 3.5-3.5Z" /></svg>
                            </span>
                            <div>
                                <h3 id="contact-heading" class="font-extrabold text-[#101928]">Contact &amp; family</h3>
                                <p class="text-xs text-slate-500">Provide numbers in the Philippine international format.</p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="contact-number" class="block text-sm font-bold text-slate-700">Contact number</label>
                                <input id="contact-number" type="tel" wire:model="contact_number" autocomplete="tel" placeholder="+639171234567" maxlength="13" inputmode="tel" pattern="\+63[0-9]{10}"
                                    class="mt-2 block min-h-12 w-full rounded-xl border-slate-200 bg-[#fdfcfb] px-4 text-sm text-slate-800 shadow-sm transition focus:border-[#b4233b] focus:bg-white focus:ring-[#b4233b]">
                                @error('contact_number') <p class="mt-1.5 text-xs font-semibold leading-5 text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="parent-name" class="block text-sm font-bold text-slate-700">Parent or guardian name</label>
                                <input id="parent-name" type="text" wire:model="parent_name"
                                    class="mt-2 block min-h-12 w-full rounded-xl border-slate-200 bg-[#fdfcfb] px-4 text-sm text-slate-800 shadow-sm transition focus:border-[#b4233b] focus:bg-white focus:ring-[#b4233b]">
                                @error('parent_name') <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="parent-contact" class="block text-sm font-bold text-slate-700">Parent or guardian contact</label>
                                <input id="parent-contact" type="tel" wire:model="parent_contact" placeholder="+639171234567" maxlength="13" inputmode="tel" pattern="\+63[0-9]{10}"
                                    class="mt-2 block min-h-12 w-full rounded-xl border-slate-200 bg-[#fdfcfb] px-4 text-sm text-slate-800 shadow-sm transition focus:border-[#b4233b] focus:bg-white focus:ring-[#b4233b]">
                                @error('parent_contact') <p class="mt-1.5 text-xs font-semibold leading-5 text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm font-bold text-slate-700">Home address <span class="text-[#a71930]">*</span></label>
                                <textarea id="address" wire:model="address" rows="3" autocomplete="street-address"
                                    class="mt-2 block w-full rounded-xl border-slate-200 bg-[#fdfcfb] px-4 py-3 text-sm leading-6 text-slate-800 shadow-sm transition focus:border-[#b4233b] focus:bg-white focus:ring-[#b4233b]"
                                    placeholder="Street, barangay, city or municipality, province"></textarea>
                                <p class="mt-1.5 text-xs text-slate-500">Include the street, barangay, city or municipality, and province.</p>
                                @error('address') <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-[#fdfcfb] px-5 py-4 sm:flex-row sm:items-center sm:justify-end sm:px-7">
                <button type="button" wire:click="cancelEdit" wire:loading.attr="disabled" wire:target="save"
                    class="inline-flex min-h-12 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-extrabold text-slate-700 shadow-sm transition duration-300 hover:border-red-200 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2 disabled:cursor-wait disabled:opacity-60">
                    Cancel
                </button>
                <button type="submit" wire:loading.attr="disabled" wire:target="save"
                    class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-[#a71930] px-5 text-sm font-extrabold text-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:bg-[#861326] hover:shadow-md active:translate-y-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2 disabled:cursor-wait disabled:opacity-70">
                    <svg wire:loading.remove wire:target="save" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" /></svg>
                    <svg wire:loading wire:target="save" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3" /><path class="opacity-75" fill="currentColor" d="M21 12a9 9 0 0 0-9-9v3a6 6 0 0 1 6 6h3Z" /></svg>
                    <span wire:loading.remove wire:target="save">Save changes</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </button>
            </div>
        </form>
    @else
        @php
            $fullName = collect([$student->firstname, $student->middlename, $student->lastname])->filter()->implode(' ');
            $birthdateLabel = $student->birthdate ? \Illuminate\Support\Carbon::parse($student->birthdate)->format('F j, Y') : 'Not provided';
        @endphp

        <section class="overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-sm" aria-labelledby="profile-name">
            <div class="h-1.5 bg-gradient-to-r from-[#8f142a] via-[#b4233b] to-[#d65a6e]" aria-hidden="true"></div>
            <div class="flex flex-col gap-6 p-5 sm:p-7 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex min-w-0 flex-col items-center gap-5 text-center sm:flex-row sm:text-left">
                    <div class="h-28 w-28 shrink-0 overflow-hidden rounded-[22px] bg-slate-100 ring-4 ring-red-50 sm:h-32 sm:w-32">
                        @if ($student->image_path)
                            <img src="{{ asset('storage/' . $student->image_path) }}" class="h-full w-full object-cover" alt="Profile photo of {{ $fullName }}">
                        @else
                            <span class="flex h-full w-full items-center justify-center bg-slate-100 text-slate-400">
                                <svg class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="12" cy="8" r="3.75" /><path stroke-linecap="round" d="M4.5 20a7.5 7.5 0 0 1 15 0" /></svg>
                            </span>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#a71930]">Official student record</p>
                        <h2 id="profile-name" class="mt-1 break-words text-2xl font-extrabold tracking-[-0.035em] text-[#101928] sm:text-3xl">{{ $fullName }}</h2>
                        <div class="mt-3 flex flex-wrap justify-center gap-2 sm:justify-start">
                            <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1.5 text-xs font-extrabold text-[#a71930] ring-1 ring-inset ring-red-100">{{ $gradeLevel }}</span>
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1.5 text-xs font-extrabold text-slate-700 ring-1 ring-inset ring-slate-200">Section {{ $section }}</span>
                        </div>
                        <p class="mt-3 text-sm font-medium text-slate-500">Review the information connected to your student account.</p>
                    </div>
                </div>

                <button type="button" wire:click="edit" wire:loading.attr="disabled" wire:target="edit"
                    class="inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-xl bg-[#a71930] px-5 text-sm font-extrabold text-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:bg-[#861326] hover:shadow-md active:translate-y-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2 disabled:cursor-wait disabled:opacity-70">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m14.5 5.5 4 4M5 19l2.7-.55L19 7.15a1.4 1.4 0 0 0 0-2l-.15-.15a1.4 1.4 0 0 0-2 0L5.55 16.3 5 19Z" /></svg>
                    Edit profile
                </button>
            </div>
        </section>

        <div class="grid gap-5 lg:grid-cols-[minmax(0,1.45fr)_minmax(300px,.75fr)]">
            <section class="rounded-[20px] border border-slate-200 bg-white p-5 shadow-sm sm:p-7" aria-labelledby="personal-details-heading">
                <div class="flex items-start gap-3 border-b border-slate-100 pb-5">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#a71930] ring-1 ring-red-100">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.5" /><path stroke-linecap="round" d="M5 20a7 7 0 0 1 14 0" /></svg>
                    </span>
                    <div>
                        <h3 id="personal-details-heading" class="text-lg font-extrabold tracking-tight text-[#101928]">Personal details</h3>
                        <p class="mt-0.5 text-sm text-slate-500">Identification and contact information on file.</p>
                    </div>
                </div>

                <dl class="mt-1 divide-y divide-slate-100">
                    <div class="grid gap-1 py-4 sm:grid-cols-[190px_minmax(0,1fr)] sm:gap-5">
                        <dt class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-[0.12em] text-slate-400">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 4h10a2 2 0 0 1 2 2v12H5V6a2 2 0 0 1 2-2Zm2 4h6M8 18v2h8v-2" /></svg>
                            Learner reference no.
                        </dt>
                        <dd class="break-words text-sm font-bold text-slate-800 sm:text-right">{{ $student->lrn ?? 'N/A' }}</dd>
                    </div>
                    <div class="grid gap-1 py-4 sm:grid-cols-[190px_minmax(0,1fr)] sm:gap-5">
                        <dt class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-[0.12em] text-slate-400">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.25 3.75h2.2l1.25 4-2.1 1.55a13.2 13.2 0 0 0 6.1 6.1l1.55-2.1 4 1.25v2.2a3.5 3.5 0 0 1-3.5 3.5c-7.18 0-13-5.82-13-13a3.5 3.5 0 0 1 3.5-3.5Z" /></svg>
                            Contact number
                        </dt>
                        <dd class="break-words text-sm font-bold text-slate-800 sm:text-right">{{ $student->contact_number ?: 'Not provided' }}</dd>
                    </div>
                    <div class="grid gap-1 py-4 sm:grid-cols-[190px_minmax(0,1fr)] sm:gap-5">
                        <dt class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-[0.12em] text-slate-400">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z" /></svg>
                            Birthdate
                        </dt>
                        <dd class="text-sm font-bold text-slate-800 sm:text-right"><time datetime="{{ $student->birthdate }}">{{ $birthdateLabel }}</time></dd>
                    </div>
                    <div class="grid gap-1 py-4 sm:grid-cols-[190px_minmax(0,1fr)] sm:gap-5">
                        <dt class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-[0.12em] text-slate-400">
                            <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 10.5 12 4l8 6.5V20h-5v-5H9v5H4v-9.5Z" /></svg>
                            Home address
                        </dt>
                        <dd class="break-words text-sm font-bold leading-6 text-slate-800 sm:text-right">{{ $student->address ?: 'Not provided' }}</dd>
                    </div>
                </dl>
            </section>

            <div class="space-y-5">
                <section class="rounded-[20px] border border-slate-200 bg-[#fdfcfb] p-5 shadow-sm sm:p-6" aria-labelledby="academic-details-heading">
                    <div class="flex items-start gap-3">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#a71930] ring-1 ring-red-100">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3.5 9 8.5-4 8.5 4-8.5 4-8.5-4Zm3 2.25V16c2.8 2.3 8.2 2.3 11 0v-4.75M20.5 9v6" /></svg>
                        </span>
                        <div>
                            <p class="text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#a71930]">Current placement</p>
                            <h3 id="academic-details-heading" class="mt-1 text-lg font-extrabold tracking-tight text-[#101928]">Academic details</h3>
                        </div>
                    </div>
                    <dl class="mt-5 grid grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-400">Grade level</dt>
                            <dd class="mt-2 break-words text-lg font-extrabold text-[#101928]">{{ $gradeLevel }}</dd>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white p-4">
                            <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-400">Section</dt>
                            <dd class="mt-2 break-words text-lg font-extrabold text-[#101928]">{{ $section }}</dd>
                        </div>
                    </dl>
                    <p class="mt-4 flex items-start gap-2 text-xs leading-5 text-slate-500">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="8.5" /><path stroke-linecap="round" d="M12 10.5V16M12 7.5h.01" /></svg>
                        Academic placement is managed by the school and cannot be edited here.
                    </p>
                </section>

                <section class="rounded-[20px] border border-slate-200 bg-white p-5 shadow-sm sm:p-6" aria-labelledby="guardian-heading">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#a71930] ring-1 ring-red-100">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="9" cy="8" r="3" /><circle cx="17" cy="10" r="2.5" /><path stroke-linecap="round" d="M3.5 20a5.5 5.5 0 0 1 11 0M14 15.5a4.5 4.5 0 0 1 6.5 4" /></svg>
                        </span>
                        <h3 id="guardian-heading" class="font-extrabold text-[#101928]">Parent or guardian</h3>
                    </div>
                    <dl class="mt-5 space-y-4">
                        <div>
                            <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-400">Full name</dt>
                            <dd class="mt-1 break-words text-sm font-bold text-slate-800">{{ $student->parent_name ?: 'Not provided' }}</dd>
                        </div>
                        <div class="border-t border-slate-100 pt-4">
                            <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-400">Contact number</dt>
                            <dd class="mt-1 break-words text-sm font-bold text-slate-800">{{ $student->parent_contact ?: 'Not provided' }}</dd>
                        </div>
                    </dl>
                </section>
            </div>
        </div>

        <section class="overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-sm" aria-labelledby="change-password-heading">
            <div class="grid lg:grid-cols-[minmax(260px,.7fr)_minmax(0,1.3fr)]">
                <div class="border-b border-slate-200 bg-[#fdfcfb] p-5 sm:p-7 lg:border-b-0 lg:border-r">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-[#a71930] ring-1 ring-red-100">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <rect x="5" y="10" width="14" height="10" rx="2" />
                            <path stroke-linecap="round" d="M8.5 10V7.5a3.5 3.5 0 0 1 7 0V10M12 14v2.5" />
                        </svg>
                    </span>
                    <p class="mt-5 text-[10px] font-extrabold uppercase tracking-[0.16em] text-[#a71930]">Account security</p>
                    <h3 id="change-password-heading" class="mt-1 text-lg font-extrabold tracking-tight text-[#101928]">Change password</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-500">Use a strong password you do not use for any other account.</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}" x-data="{ submitting: false }" @submit="submitting = true" class="p-5 sm:p-7">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="current-password" class="block text-sm font-bold text-slate-700">Current password <span class="text-[#a71930]">*</span></label>
                            <input id="current-password" name="current_password" type="password" required autocomplete="current-password"
                                class="mt-2 block min-h-12 w-full rounded-xl bg-[#fdfcfb] px-4 text-sm text-slate-800 shadow-sm transition focus:bg-white focus:border-[#b4233b] focus:ring-[#b4233b] @error('current_password', 'updatePassword') border-red-400 @else border-slate-200 @enderror">
                            @error('current_password', 'updatePassword')
                                <p class="mt-1.5 text-xs font-semibold text-red-600" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="new-password" class="block text-sm font-bold text-slate-700">New password <span class="text-[#a71930]">*</span></label>
                            <input id="new-password" name="password" type="password" required autocomplete="new-password"
                                class="mt-2 block min-h-12 w-full rounded-xl bg-[#fdfcfb] px-4 text-sm text-slate-800 shadow-sm transition focus:bg-white focus:border-[#b4233b] focus:ring-[#b4233b] @error('password', 'updatePassword') border-red-400 @else border-slate-200 @enderror">
                            @error('password', 'updatePassword')
                                <p class="mt-1.5 text-xs font-semibold text-red-600" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password-confirmation" class="block text-sm font-bold text-slate-700">Confirm new password <span class="text-[#a71930]">*</span></label>
                            <input id="password-confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                                class="mt-2 block min-h-12 w-full rounded-xl border-slate-200 bg-[#fdfcfb] px-4 text-sm text-slate-800 shadow-sm transition focus:border-[#b4233b] focus:bg-white focus:ring-[#b4233b]">
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end border-t border-slate-100 pt-5">
                        <button type="submit" :disabled="submitting"
                            class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-[#a71930] px-5 text-sm font-extrabold text-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:bg-[#861326] hover:shadow-md active:translate-y-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2 disabled:cursor-wait disabled:opacity-70">
                            <svg x-show="! submitting" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <rect x="5" y="10" width="14" height="10" rx="2" />
                                <path stroke-linecap="round" d="M8.5 10V7.5a3.5 3.5 0 0 1 7 0V10" />
                            </svg>
                            <svg x-show="submitting" x-cloak class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3" /><path class="opacity-75" fill="currentColor" d="M21 12a9 9 0 0 0-9-9v3a6 6 0 0 1 6 6h3Z" /></svg>
                            <span x-text="submitting ? 'Updating...' : 'Update password'">Update password</span>
                        </button>
                    </div>
                </form>
            </div>
        </section>
    @endif
</div>
