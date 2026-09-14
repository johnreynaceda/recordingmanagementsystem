<x-landing-layout>
    @section('title', 'News & Announcements')

    <section class="relative isolate overflow-hidden border-b border-slate-200 bg-white">
        <img src="{{ asset('images/bg.jpg') }}" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-30" alt="Trece Martires City National High School campus">
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-white via-white/95 to-white/70"></div>
        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-[#fbfaf8] via-transparent to-white/20"></div>
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-24 lg:px-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white/90 px-3.5 py-2 text-[11px] font-extrabold uppercase tracking-[0.16em] text-[#a71930] shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-[#b4233b]"></span>Official updates
                </div>
                <h1 class="mt-6 text-4xl font-extrabold tracking-[-0.035em] text-[#101928] sm:text-5xl lg:text-6xl">News &amp; Announcements</h1>
                <p class="mt-5 max-w-2xl text-base font-medium leading-8 text-slate-600 sm:text-lg">Stay informed with important notices, school activities, schedules, and official updates from Trece Martires City National High School.</p>
            </div>
        </div>
    </section>

    <section class="min-h-[60vh] bg-[#fbfaf8] py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-9 flex flex-col gap-2 border-b border-slate-200 pb-7 sm:flex-row sm:items-end sm:justify-between">
                <div><p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#a71930]">Bulletin</p><h2 class="mt-2 text-2xl font-extrabold tracking-tight text-[#101928]">From the school administration</h2></div>
                <p class="text-sm font-medium text-slate-500">Newest announcements appear first</p>
            </div>
            <livewire:public.announcement-list />
        </div>
    </section>
</x-landing-layout>
