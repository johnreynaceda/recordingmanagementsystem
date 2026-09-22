<div class="mx-auto max-w-7xl space-y-5 sm:space-y-6">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity
            class="flex items-start justify-between gap-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-emerald-800 shadow-sm"
            role="status">
            <div class="flex min-w-0 items-start gap-3">
                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-emerald-600 ring-1 ring-emerald-200">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" /></svg>
                </span>
                <div>
                    <p class="text-sm font-extrabold">Profile updated</p>
                    <p class="mt-0.5 text-sm font-medium text-emerald-700">{{ session('message') }}</p>
                </div>
            </div>
            <button type="button" @click="show = false"
                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg transition hover:bg-emerald-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600"
                aria-label="Dismiss notification">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" /></svg>
            </button>
        </div>
    @endif

    @if (! $record)
        <section class="rounded-[20px] border border-dashed border-slate-300 bg-white px-6 py-14 text-center shadow-sm" aria-labelledby="teacher-profile-unavailable">
            <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-[#a71930] ring-1 ring-red-100">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.75" /><path stroke-linecap="round" d="M4.5 20a7.5 7.5 0 0 1 15 0" /></svg>
            </span>
            <h2 id="teacher-profile-unavailable" class="mt-5 text-xl font-extrabold tracking-tight text-[#101928]">Teacher profile unavailable</h2>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">No staff record is linked to this account. Please contact the school administrator for assistance.</p>
        </section>
    @else
        @php
            $initials = mb_strtoupper(mb_substr($firstname ?? '', 0, 1).mb_substr($lastname ?? '', 0, 1));
            $sectionCount = count($assignedSections);
            $subjectCount = count($assignedSubjects);
        @endphp

        <section class="overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-sm" aria-labelledby="teacher-profile-name">
            <div class="h-1.5 bg-gradient-to-r from-[#8f142a] via-[#b4233b] to-[#d65a6e]" aria-hidden="true"></div>
            <div class="flex flex-col gap-6 p-5 sm:p-7 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex min-w-0 flex-col items-center gap-5 text-center sm:flex-row sm:text-left">
                    <span class="flex h-24 w-24 shrink-0 items-center justify-center rounded-[22px] bg-[#101928] text-2xl font-extrabold tracking-tight text-white ring-4 ring-red-50 sm:h-28 sm:w-28" aria-hidden="true">
                        {{ $initials ?: 'TC' }}
                    </span>
                    <div class="min-w-0">
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#a71930]">Faculty profile</p>
                        <h2 id="teacher-profile-name" class="mt-1 break-words text-2xl font-extrabold tracking-[-0.035em] text-[#101928] sm:text-3xl">{{ $firstname }} {{ $lastname }}</h2>
                        <p class="mt-2 flex items-start justify-center gap-2 text-sm leading-6 text-slate-500 sm:justify-start">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#a71930]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10c0 5.25-7.5 10-7.5 10s-7.5-4.75-7.5-10a7.5 7.5 0 1 1 15 0Z" /><circle cx="12" cy="10" r="2.5" /></svg>
                            <span class="break-words">{{ $address ?: 'Address not provided' }}</span>
                        </p>
                        <div class="mt-3 flex flex-wrap justify-center gap-2 sm:justify-start">
                            <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1.5 text-xs font-extrabold text-[#a71930] ring-1 ring-inset ring-red-100">Teacher</span>
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600 ring-1 ring-inset ring-slate-200">{{ $activeAcademicYearName ? 'S.Y. '.$activeAcademicYearName : 'No active school year' }}</span>
                        </div>
                    </div>
                </div>

                <button type="button" wire:click="openEditModal" wire:loading.attr="disabled" wire:target="openEditModal"
                    class="inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-xl bg-[#a71930] px-5 text-sm font-extrabold text-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:bg-[#861326] hover:shadow-md active:translate-y-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2 disabled:cursor-wait disabled:opacity-70">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m14.5 5.5 4 4M5 19l2.7-.55L19 7.15a1.4 1.4 0 0 0 0-2l-.15-.15a1.4 1.4 0 0 0-2 0L5.55 16.3 5 19Z" /></svg>
                    Edit profile
                </button>
            </div>
        </section>

        <section class="rounded-[20px] border border-slate-200 bg-white p-5 shadow-sm sm:p-7" aria-labelledby="teaching-assignments-heading">
            <div class="flex flex-col gap-5 border-b border-slate-100 pb-6 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex items-start gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#a71930] ring-1 ring-red-100">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3.5 9 8.5-4 8.5 4-8.5 4-8.5-4Zm3 2.25V16c2.8 2.3 8.2 2.3 11 0v-4.75M20.5 9v6" /></svg>
                    </span>
                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#a71930]">{{ $activeAcademicYearName ? 'School year '.$activeAcademicYearName : 'Current school year' }}</p>
                        <h2 id="teaching-assignments-heading" class="mt-1 text-xl font-extrabold tracking-[-0.025em] text-[#101928]">Teaching assignments by grade level</h2>
                        <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">All sections assigned for advisory work and all subjects assigned for teaching are listed together by grade level.</p>
                    </div>
                </div>

                <dl class="grid shrink-0 grid-cols-2 gap-3" aria-label="Assignment totals">
                    <div class="min-w-24 rounded-xl border border-slate-200 bg-[#fdfcfb] px-4 py-3 text-center">
                        <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-400">Sections</dt>
                        <dd class="mt-1 text-xl font-extrabold text-[#101928]">{{ $sectionCount }}</dd>
                    </div>
                    <div class="min-w-24 rounded-xl border border-slate-200 bg-[#fdfcfb] px-4 py-3 text-center">
                        <dt class="text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-400">Subjects</dt>
                        <dd class="mt-1 text-xl font-extrabold text-[#101928]">{{ $subjectCount }}</dd>
                    </div>
                </dl>
            </div>

            @if (count($assignmentGroups) > 0)
                <div class="mt-6 grid gap-5 xl:grid-cols-2">
                    @foreach ($assignmentGroups as $group)
                        <article class="overflow-hidden rounded-[20px] border border-slate-200 bg-[#fdfcfb] transition duration-300 hover:border-red-200 hover:shadow-lg hover:shadow-slate-200/60" aria-labelledby="grade-group-{{ $group['id'] ?? 'other' }}">
                            <header class="flex items-center justify-between gap-4 border-b border-slate-200 bg-white px-5 py-4">
                                <div class="flex min-w-0 items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#a71930] text-sm font-extrabold text-white">
                                        {{ preg_replace('/\D+/', '', $group['name']) ?: 'G' }}
                                    </span>
                                    <div class="min-w-0">
                                        <p class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-[#a71930]">Grade level</p>
                                        <h3 id="grade-group-{{ $group['id'] ?? 'other' }}" class="truncate text-lg font-extrabold text-[#101928]">{{ $group['name'] }}</h3>
                                    </div>
                                </div>
                                <span class="shrink-0 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                                    {{ count($group['sections']) + count($group['subjects']) }} {{ \Illuminate\Support\Str::plural('assignment', count($group['sections']) + count($group['subjects'])) }}
                                </span>
                            </header>

                            <div class="grid gap-5 p-5 sm:grid-cols-2">
                                <section aria-labelledby="sections-{{ $group['id'] ?? 'other' }}">
                                    <div class="flex items-center justify-between gap-3">
                                        <h4 id="sections-{{ $group['id'] ?? 'other' }}" class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-[0.12em] text-slate-500">
                                            <svg class="h-4 w-4 text-[#a71930]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="9" cy="8" r="3" /><circle cx="17" cy="10" r="2.5" /><path stroke-linecap="round" d="M3.5 20a5.5 5.5 0 0 1 11 0M14 15.5a4.5 4.5 0 0 1 6.5 4" /></svg>
                                            Assigned sections
                                        </h4>
                                        <span class="text-xs font-extrabold text-slate-400">{{ count($group['sections']) }}</span>
                                    </div>
                                    @if (count($group['sections']) > 0)
                                        <ul class="mt-3 space-y-2">
                                            @foreach ($group['sections'] as $section)
                                                <li class="flex min-h-11 items-center gap-3 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-bold text-slate-800">
                                                    <span class="h-2 w-2 shrink-0 rounded-full bg-[#a71930]" aria-hidden="true"></span>
                                                    <span class="break-words">{{ $section['name'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="mt-3 rounded-xl border border-dashed border-slate-300 bg-white px-3.5 py-3 text-xs leading-5 text-slate-500">No section assigned for this grade.</p>
                                    @endif
                                </section>

                                <section aria-labelledby="subjects-{{ $group['id'] ?? 'other' }}">
                                    <div class="flex items-center justify-between gap-3">
                                        <h4 id="subjects-{{ $group['id'] ?? 'other' }}" class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-[0.12em] text-slate-500">
                                            <svg class="h-4 w-4 text-[#a71930]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5h5.25A2.25 2.25 0 0 1 12 6.75V20a3.75 3.75 0 0 0-3.75-3.75H4.5V4.5Zm15 0h-5.25A2.25 2.25 0 0 0 12 6.75V20a3.75 3.75 0 0 1 3.75-3.75h3.75V4.5Z" /></svg>
                                            Assigned subjects
                                        </h4>
                                        <span class="text-xs font-extrabold text-slate-400">{{ count($group['subjects']) }}</span>
                                    </div>
                                    @if (count($group['subjects']) > 0)
                                        <ul class="mt-3 space-y-2">
                                            @foreach ($group['subjects'] as $subject)
                                                <li class="flex min-h-11 items-center gap-3 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-bold text-slate-800">
                                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-red-50 text-[#a71930] ring-1 ring-red-100">
                                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="m7 12 3 3 7-7" /></svg>
                                                    </span>
                                                    <span class="break-words">{{ $subject['name'] }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="mt-3 rounded-xl border border-dashed border-slate-300 bg-white px-3.5 py-3 text-xs leading-5 text-slate-500">No subject assigned for this grade.</p>
                                    @endif
                                </section>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-400 ring-1 ring-slate-200">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 5h14v14H5V5Zm3 4h8M8 13h5" /></svg>
                    </span>
                    <h3 class="mt-4 text-base font-extrabold text-[#101928]">No active assignments</h3>
                    <p class="mx-auto mt-1 max-w-md text-sm leading-6 text-slate-500">
                        {{ $activeAcademicYearName ? 'No sections or subjects are assigned to you for school year '.$activeAcademicYearName.'.' : 'An active school year has not been configured yet.' }}
                    </p>
                </div>
            @endif
        </section>

        <div x-data="{ open: @entangle('showModal') }" x-show="open" x-cloak @keydown.escape.window="$wire.cancelEdit()"
            class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4" role="dialog" aria-modal="true" aria-labelledby="edit-teacher-profile-title">
            <div x-show="open" x-transition.opacity class="absolute inset-0 bg-slate-950/60" wire:click="cancelEdit" aria-hidden="true"></div>

            <form wire:submit.prevent="update" x-show="open" x-transition.origin.bottom
                class="relative max-h-[calc(100dvh-1.5rem)] w-full max-w-lg overflow-y-auto rounded-[20px] border border-slate-200 bg-white shadow-2xl">
                <div class="h-1.5 bg-gradient-to-r from-[#8f142a] via-[#b4233b] to-[#d65a6e]" aria-hidden="true"></div>
                <div class="flex items-start justify-between gap-4 border-b border-slate-200 px-5 py-5 sm:px-6">
                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#a71930]">Profile settings</p>
                        <h2 id="edit-teacher-profile-title" class="mt-1 text-xl font-extrabold tracking-tight text-[#101928]">Update your profile</h2>
                        <p class="mt-1 text-sm text-slate-500">Keep your name and address current.</p>
                    </div>
                    <button type="button" wire:click="cancelEdit"
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b]"
                        aria-label="Close profile form">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" /></svg>
                    </button>
                </div>

                <div class="space-y-5 px-5 py-6 sm:px-6">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="teacher-firstname" class="block text-sm font-bold text-slate-700">First name <span class="text-[#a71930]">*</span></label>
                            <input id="teacher-firstname" type="text" wire:model="firstname" autocomplete="given-name" autofocus
                                class="mt-2 block min-h-12 w-full rounded-xl border-slate-200 bg-[#fdfcfb] px-4 text-sm text-slate-800 shadow-sm transition focus:border-[#b4233b] focus:bg-white focus:ring-[#b4233b]">
                            @error('firstname') <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="teacher-lastname" class="block text-sm font-bold text-slate-700">Last name <span class="text-[#a71930]">*</span></label>
                            <input id="teacher-lastname" type="text" wire:model="lastname" autocomplete="family-name"
                                class="mt-2 block min-h-12 w-full rounded-xl border-slate-200 bg-[#fdfcfb] px-4 text-sm text-slate-800 shadow-sm transition focus:border-[#b4233b] focus:bg-white focus:ring-[#b4233b]">
                            @error('lastname') <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="teacher-address" class="block text-sm font-bold text-slate-700">Address <span class="text-[#a71930]">*</span></label>
                        <textarea id="teacher-address" wire:model="address" rows="3" autocomplete="street-address"
                            class="mt-2 block w-full rounded-xl border-slate-200 bg-[#fdfcfb] px-4 py-3 text-sm leading-6 text-slate-800 shadow-sm transition focus:border-[#b4233b] focus:bg-white focus:ring-[#b4233b]"
                            placeholder="Street, barangay, city or municipality, province"></textarea>
                        @error('address') <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-[#fdfcfb] px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                    <button type="button" wire:click="cancelEdit" wire:loading.attr="disabled" wire:target="update"
                        class="inline-flex min-h-12 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-extrabold text-slate-700 shadow-sm transition duration-300 hover:border-red-200 hover:text-[#a71930] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2 disabled:opacity-60">
                        Cancel
                    </button>
                    <button type="submit" wire:loading.attr="disabled" wire:target="update"
                        class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-[#a71930] px-5 text-sm font-extrabold text-white shadow-sm transition duration-300 hover:-translate-y-0.5 hover:bg-[#861326] hover:shadow-md active:translate-y-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2 disabled:cursor-wait disabled:opacity-70">
                        <svg wire:loading.remove wire:target="update" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" /></svg>
                        <svg wire:loading wire:target="update" class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3" /><path class="opacity-75" fill="currentColor" d="M21 12a9 9 0 0 0-9-9v3a6 6 0 0 1 6 6h3Z" /></svg>
                        <span wire:loading.remove wire:target="update">Save changes</span>
                        <span wire:loading wire:target="update">Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
