<section class="overflow-hidden rounded-2xl border border-amber-200 bg-white shadow-sm">
    <div class="flex flex-col gap-4 border-b border-amber-200 bg-amber-50 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div class="flex items-start gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-700">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.25 16.5a6.75 6.75 0 0 1 13.5 0 .75.75 0 0 1-.75.75H4a.75.75 0 0 1-.75-.75ZM16.75 6.5a.75.75 0 0 0-1.5 0v1.75H13.5a.75.75 0 0 0 0 1.5h1.75v1.75a.75.75 0 0 0 1.5 0V9.75h1.75a.75.75 0 0 0 0-1.5h-1.75V6.5Z" />
                </svg>
            </span>
            <div>
                <h2 class="text-lg font-bold text-amber-950">Unassigned student registrations</h2>
                <p class="mt-1 text-sm leading-5 text-amber-800">Review self-registered students, then proceed with placement or reject the registration.</p>
            </div>
        </div>

        <span class="inline-flex w-fit items-center rounded-full bg-amber-100 px-3 py-1.5 text-sm font-bold text-amber-800">
            {{ $unassignedCount }} {{ Str::plural('student', $unassignedCount) }} pending
        </span>
    </div>

    <div class="p-4 sm:p-6">
        {{ $this->table }}
    </div>
</section>
