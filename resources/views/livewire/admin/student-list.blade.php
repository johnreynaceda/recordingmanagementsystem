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

                <div class="grid grid-cols-3 gap-3 text-center sm:min-w-96">
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
                </div>
            </div>
        </div>

        <div class="border-t border-slate-100 bg-white p-4 sm:p-5">
        {{ $this->table }}
        </div>
    </div>
</div>
