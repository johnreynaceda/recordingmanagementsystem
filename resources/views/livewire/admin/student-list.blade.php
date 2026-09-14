<div class="space-y-6">
    <div class="overflow-hidden rounded-2xl border border-red-100 bg-white shadow-sm">
        <div class="relative bg-slate-950 px-5 py-6 text-white sm:px-6">
            <div class="absolute inset-y-0 right-0 hidden w-1/2 bg-gradient-to-l from-main/30 to-transparent sm:block"></div>

            <div class="relative flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-red-200">Student Directory</p>
                    <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Manage student records</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-300">
                        Search, filter, update profiles, and open each student's academic record from one workspace.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3 text-center sm:min-w-[32rem] lg:grid-cols-4">
                    <div class="rounded-xl border border-white/10 bg-white/10 px-4 py-3 backdrop-blur">
                        <p class="text-2xl font-bold">{{ number_format($total_students) }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-300">Total</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-emerald-400/15 px-4 py-3 backdrop-blur">
                        <p class="text-2xl font-bold text-emerald-100">{{ number_format($active_students) }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-emerald-100/80">Active</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-red-400/15 px-4 py-3 backdrop-blur">
                        <p class="text-2xl font-bold text-red-100">{{ number_format($graduated_students) }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-red-100/80">Graduated</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-amber-400/15 px-4 py-3 backdrop-blur">
                        <p class="text-2xl font-bold text-amber-100">{{ number_format($unassigned_students) }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-amber-100/80">Unassigned</p>
                    </div>
                </div>
            </div>
        </div>

        @if ($unassigned_students > 0)
            <div class="border-b border-amber-200 bg-amber-50 px-4 py-4 sm:px-5">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.674 1.167-.168 2.63-1.514 2.63H3.72c-1.347 0-2.189-1.463-1.515-2.63l6.28-10.875ZM10 6a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 6Zm0 7a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-bold text-amber-900">
                                {{ $unassigned_students }} {{ Str::plural('student', $unassigned_students) }} {{ $unassigned_students === 1 ? 'needs' : 'need' }} placement
                            </p>
                            <p class="mt-0.5 text-sm text-amber-800">
                                These self-registered records do not have a complete grade level and section assignment.
                            </p>
                        </div>
                    </div>
                    <p class="text-sm font-semibold text-amber-800">Use “Proceed” to assign placement or “Reject” to decline the registration.</p>
                </div>
            </div>
        @endif

        <div class="border-t border-slate-100 bg-white p-4 sm:p-5">
            {{ $this->table }}
        </div>
    </div>
</div>
