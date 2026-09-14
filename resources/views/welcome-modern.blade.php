@section('title', 'Official School Portal')

<x-landing-layout>
    <section class="relative isolate overflow-hidden bg-white">
        <img src="{{ asset('images/bg.jpg') }}" alt="Trece Martires City National High School campus" class="absolute inset-0 -z-20 h-full w-full object-cover object-center">
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-white via-white/95 to-white/75"></div>
        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-[#fbfaf8] via-transparent to-white/35"></div>
        <div class="absolute -left-24 bottom-0 -z-10 h-64 w-64 rounded-full bg-red-100/50 blur-3xl"></div>

        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-16 sm:px-6 sm:py-20 lg:grid-cols-12 lg:gap-16 lg:px-8 lg:py-24">
            <div class="lg:col-span-7">
                <div class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white/90 px-3.5 py-2 text-[11px] font-extrabold uppercase tracking-[0.16em] text-[#a71930] shadow-sm">
                    <span class="h-2 w-2 rounded-full bg-[#b4233b]"></span>Official School Portal
                </div>
                <h1 class="mt-6 max-w-3xl text-4xl font-extrabold leading-[1.08] tracking-[-0.035em] text-[#101928] sm:text-5xl lg:text-[62px]">
                    <span class="block">Trece Martires City</span>
                    <span class="block text-[#a71930]">National High School</span>
                </h1>
                <p class="mt-6 max-w-2xl text-base font-medium leading-8 text-slate-600 sm:text-lg">
                    A welcoming community committed to quality education, character development, and preparing every learner with the knowledge and confidence to thrive in the future.
                </p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('about') }}" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-[#a71930] px-6 py-3 text-sm font-extrabold text-white shadow-lg shadow-red-950/15 transition duration-300 hover:-translate-y-0.5 hover:bg-[#861326] hover:shadow-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2">
                        Explore Our School
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                    </a>
                    <a href="{{ route('announcements') }}" class="inline-flex min-h-12 items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white/90 px-6 py-3 text-sm font-extrabold text-slate-800 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:border-red-200 hover:text-[#a71930] hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2">
                        View Announcements
                    </a>
                </div>
                <div class="mt-10 flex items-center gap-4 text-sm font-semibold text-slate-600">
                    <span class="flex -space-x-2" aria-hidden="true">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-red-100 text-[#a71930]"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m3 9 9-5 9 5-9 5-9-5Zm3 3v4.5c3.5 2.3 8.5 2.3 12 0V12"/></svg></span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-slate-100 text-slate-700"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75 14.4 8.6l5.35.78-3.87 3.77.91 5.32L12 15.95l-4.79 2.52.91-5.32-3.87-3.77 5.35-.78L12 3.75Z"/></svg></span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-amber-50 text-amber-700"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3.75h10.5v5.5a5.25 5.25 0 1 1-10.5 0v-5.5ZM8.25 19.5h7.5M12 14.5v5"/></svg></span>
                    </span>
                    <span>Serving Treceño learners since 1966</span>
                </div>
            </div>

            <div class="mx-auto w-full max-w-[470px] lg:col-span-5 lg:ml-auto">
                <div class="overflow-hidden rounded-[24px] border border-slate-200/90 bg-white shadow-[0_24px_70px_-28px_rgba(15,23,42,0.35)]">
                    <div class="h-1.5 bg-gradient-to-r from-[#8d1429] via-[#c52a45] to-[#e56a79]"></div>
                    <div class="p-6 sm:p-8">
                        <div class="flex items-start gap-4">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-red-50 text-[#a71930] ring-1 ring-red-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10V7.5a4 4 0 0 1 8 0V10m-9.25 0h10.5A1.75 1.75 0 0 1 19 11.75v7.5A1.75 1.75 0 0 1 17.25 21H6.75A1.75 1.75 0 0 1 5 19.25v-7.5A1.75 1.75 0 0 1 6.75 10ZM12 14v3"/></svg>
                            </span>
                            <div><p class="text-[10px] font-extrabold uppercase tracking-[0.18em] text-[#a71930]">Secure sign in</p><h2 class="mt-1 text-2xl font-extrabold tracking-tight text-[#101928]">Access Your Portal</h2><p class="mt-2 text-sm leading-6 text-slate-500">Choose your portal to continue to your secure account.</p></div>
                        </div>

                        <div class="mt-7 space-y-3">
                            <a href="{{ route('student-login') }}" class="group flex min-h-[84px] items-center gap-4 rounded-2xl bg-[#a71930] p-4 text-white shadow-md shadow-red-950/15 transition duration-300 hover:-translate-y-0.5 hover:bg-[#861326] hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2 active:translate-y-0">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white/12 ring-1 ring-white/15"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 8.5 9-4.5 9 4.5-9 4.5-9-4.5Zm3 2v5.25c3.5 2.5 8.5 2.5 12 0V10.5M21 8.5v6"/></svg></span>
                                <span class="min-w-0 flex-1"><span class="block text-base font-extrabold">Student Portal</span><span class="mt-0.5 block text-xs font-medium text-white/75">Grades, requests, calendar, and records</span></span>
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-white/10 transition group-hover:translate-x-1 group-hover:bg-white/15"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg></span>
                            </a>
                            <a href="{{ route('faculty-staff-login') }}" class="group flex min-h-[84px] items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 text-slate-800 transition duration-300 hover:-translate-y-0.5 hover:border-red-200 hover:shadow-lg hover:shadow-slate-200/70 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b4233b] focus-visible:ring-offset-2 active:translate-y-0">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#a71930] ring-1 ring-red-100"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V5.5A2.5 2.5 0 0 1 10.5 3h3A2.5 2.5 0 0 1 16 5.5V7M5.25 7h13.5A1.75 1.75 0 0 1 20.5 8.75v9.5A1.75 1.75 0 0 1 18.75 20H5.25a1.75 1.75 0 0 1-1.75-1.75v-9.5A1.75 1.75 0 0 1 5.25 7ZM3.5 12a22.5 22.5 0 0 0 17 0M12 11.5v2"/></svg></span>
                                <span class="min-w-0 flex-1"><span class="block text-base font-extrabold transition group-hover:text-[#a71930]">Faculty &amp; Staff Portal</span><span class="mt-0.5 block text-xs font-medium text-slate-500">Teaching and administrative services</span></span>
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-50 text-slate-400 transition group-hover:translate-x-1 group-hover:bg-red-50 group-hover:text-[#a71930]"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg></span>
                            </a>
                        </div>
                        <p class="mt-5 flex items-center justify-center gap-2 text-center text-[11px] font-semibold text-slate-400"><svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4m5.5 2c0 5.2-3.6 8-8.5 9.5C7.1 20 3.5 17.2 3.5 12V5.5L12 2l8.5 3.5V12Z"/></svg>Your account is protected by secure authentication</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative -mt-px border-y border-slate-200 bg-white" aria-labelledby="glance-heading">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <div class="mb-6 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-xs font-extrabold uppercase tracking-[0.18em] text-[#a71930]">Our community</p><h2 id="glance-heading" class="mt-1 text-xl font-extrabold tracking-tight text-[#101928]">School at a Glance</h2></div><p class="text-xs font-semibold text-slate-400">Live portal records and school information</p></div>
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['value' => number_format($studentCount), 'label' => 'Students', 'icon' => 'students'],
                    ['value' => number_format($staffCount), 'label' => 'Faculty & Staff', 'icon' => 'staff'],
                    ['value' => '3', 'label' => 'Programs', 'icon' => 'program'],
                    ['value' => now()->year - 1966, 'label' => 'Years of Service', 'icon' => 'year'],
                ] as $stat)
                    <div class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-[#fdfcfb] p-5 transition duration-300 hover:border-red-200 hover:bg-white hover:shadow-md">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#a71930] ring-1 ring-red-100">
                            @if ($stat['icon'] === 'students')<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="m3 8.5 9-4.5 9 4.5-9 4.5-9-4.5Zm3 2v5.25c3.5 2.5 8.5 2.5 12 0V10.5"/></svg>
                            @elseif ($stat['icon'] === 'staff')<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M15.5 19.5v-1.25A3.25 3.25 0 0 0 12.25 15h-5.5a3.25 3.25 0 0 0-3.25 3.25v1.25M9.5 11.25a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM16 5a3.5 3.5 0 0 1 0 6.75M20.5 19.5v-1.25A3.25 3.25 0 0 0 18 15.1"/></svg>
                            @elseif ($stat['icon'] === 'program')<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3.5h12A2.5 2.5 0 0 1 19.5 6v14.5H7.25A2.75 2.75 0 0 1 4.5 17.75V4A.5.5 0 0 1 5 3.5Zm2.25 13H19.5M8 7.5h8"/></svg>
                            @else<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v3M19 3v3M3.5 9h17M5.5 5h13a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-13a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/></svg>@endif
                        </span>
                        <div><p class="text-2xl font-extrabold tracking-tight text-[#101928]">{{ $stat['value'] }}</p><p class="text-xs font-bold text-slate-500">{{ $stat['label'] }}</p></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[#fbfaf8] py-20 sm:py-24" aria-labelledby="guides-heading">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center"><p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#a71930]">Our foundation</p><h2 id="guides-heading" class="mt-3 text-3xl font-extrabold tracking-tight text-[#101928] sm:text-4xl">What Guides Us</h2><p class="mt-4 text-base leading-7 text-slate-600">The principles that shape our learning community and guide every learner toward a purposeful future.</p></div>
            <div class="mt-12 grid gap-5 md:grid-cols-3">
                <article class="group rounded-[20px] border border-slate-200 bg-white p-7 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-red-200 hover:shadow-xl hover:shadow-slate-200/70">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-[#a71930] ring-1 ring-red-100"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="1" fill="currentColor" stroke="none"/></svg></span>
                    <h3 class="mt-6 text-xl font-extrabold text-[#101928]">Our Mission</h3><p class="mt-3 text-sm leading-7 text-slate-600">To raise the quality of learners and empower them to become self-reliant, productive, and responsible citizens.</p>
                </article>
                <article class="group rounded-[20px] border border-slate-200 bg-white p-7 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-red-200 hover:shadow-xl hover:shadow-slate-200/70">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-[#a71930] ring-1 ring-red-100"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M2.75 12s3.25-5.5 9.25-5.5 9.25 5.5 9.25 5.5-3.25 5.5-9.25 5.5S2.75 12 2.75 12Z"/><circle cx="12" cy="12" r="2.5"/></svg></span>
                    <h3 class="mt-6 text-xl font-extrabold text-[#101928]">Our Vision</h3><p class="mt-3 text-sm leading-7 text-slate-600">Learners who are high-performing, personally developed, and committed to living productive and meaningful lives.</p>
                </article>
                <article class="group rounded-[20px] border border-slate-200 bg-white p-7 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-red-200 hover:shadow-xl hover:shadow-slate-200/70">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-[#a71930] ring-1 ring-red-100"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3.5 14.5 8l5 .9-3.45 3.7.7 5.1L12 15.5l-4.75 2.2.7-5.1L4.5 8.9l5-.9L12 3.5Z"/></svg></span>
                    <h3 class="mt-6 text-xl font-extrabold text-[#101928]">Core Values</h3><p class="mt-3 text-sm leading-7 text-slate-600">Maka-Diyos, Maka-tao, Makakalikasan, and Makabansa—values that nurture principled, compassionate graduates.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="programs" class="scroll-mt-24 border-y border-slate-200 bg-white py-16" aria-labelledby="programs-heading">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-12 lg:items-center lg:px-8">
            <div class="lg:col-span-4"><p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#a71930]">K–12 education</p><h2 id="programs-heading" class="mt-3 text-3xl font-extrabold tracking-tight text-[#101928]">Learning for every path</h2><p class="mt-4 text-sm leading-7 text-slate-600">Programs designed to build strong foundations, discover strengths, and prepare learners for further education and life.</p></div>
            <div class="grid gap-3 sm:grid-cols-3 lg:col-span-8">
                @foreach ([['General Curriculum', 'A well-rounded secondary education foundation.'], ['Science Curriculum', 'Advanced learning for curious, analytical minds.'], ['Special Program in the Arts', 'Creative growth across multiple art disciplines.']] as $program)
                    <div class="rounded-2xl border border-slate-200 bg-[#fbfaf8] p-5"><span class="text-xs font-extrabold text-[#a71930]">0{{ $loop->iteration }}</span><h3 class="mt-4 text-base font-extrabold text-[#101928]">{{ $program[0] }}</h3><p class="mt-2 text-xs leading-6 text-slate-500">{{ $program[1] }}</p></div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[#fbfaf8] py-20 sm:py-24" aria-labelledby="announcements-heading">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between"><div><p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#a71930]">News & updates</p><h2 id="announcements-heading" class="mt-3 text-3xl font-extrabold tracking-tight text-[#101928] sm:text-4xl">Latest Announcements</h2><p class="mt-3 max-w-xl text-sm leading-7 text-slate-600">Important notices and updates from the school administration.</p></div><a href="{{ route('announcements') }}" class="inline-flex items-center gap-2 text-sm font-extrabold text-[#a71930] transition hover:text-[#861326]">View all announcements<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg></a></div>
            <div class="mt-10 grid gap-5 md:grid-cols-3">
                @forelse ($announcements as $announcement)
                    <article class="group flex min-h-[290px] flex-col rounded-[20px] border border-slate-200 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-red-200 hover:shadow-xl hover:shadow-slate-200/70">
                        <div class="flex items-center justify-between gap-3"><span class="rounded-full bg-red-50 px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.12em] text-[#a71930]">Announcement</span><time datetime="{{ $announcement->created_at->toDateString() }}" class="text-xs font-bold text-slate-400">{{ $announcement->created_at->format('M d, Y') }}</time></div>
                        <h3 class="mt-6 text-lg font-extrabold leading-7 text-[#101928]">{{ $announcement->title }}</h3><p class="mt-3 line-clamp-3 text-sm leading-7 text-slate-600">{{ Str::limit(strip_tags($announcement->content), 150) }}</p>
                        <a href="{{ route('announcements') }}" class="mt-auto inline-flex items-center gap-2 pt-6 text-sm font-extrabold text-[#a71930]">Read More<svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg></a>
                    </article>
                @empty
                    @foreach ([['School announcements will appear here', 'There are no active announcements at the moment. Please check back for official school updates.'], ['Enrollment updates', 'Enrollment schedules, requirements, and related advisories will be published through this official portal.'], ['Activities and reminders', 'Watch this space for school events, calendar reminders, and important community notices.']] as $notice)
                        <article class="flex min-h-[260px] flex-col rounded-[20px] border border-slate-200 bg-white p-6 shadow-sm"><div class="flex items-center justify-between"><span class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-extrabold uppercase tracking-[0.12em] text-slate-500">Updates</span><span class="text-xs font-bold text-slate-400">TMCNHS</span></div><h3 class="mt-6 text-lg font-extrabold leading-7 text-[#101928]">{{ $notice[0] }}</h3><p class="mt-3 text-sm leading-7 text-slate-600">{{ $notice[1] }}</p><a href="{{ route('announcements') }}" class="mt-auto inline-flex items-center gap-2 pt-6 text-sm font-extrabold text-[#a71930]">View announcements<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg></a></article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-white px-4 py-16 sm:px-6 lg:px-8">
        <div class="relative mx-auto max-w-7xl overflow-hidden rounded-[24px] bg-gradient-to-r from-[#8f142a] to-[#b4233b] px-6 py-10 text-white shadow-xl shadow-red-950/15 sm:px-10 lg:flex lg:items-center lg:justify-between lg:px-14">
            <div class="absolute -right-16 -top-24 h-60 w-60 rounded-full border-[36px] border-white/5" aria-hidden="true"></div>
            <div class="relative max-w-2xl"><p class="text-xs font-extrabold uppercase tracking-[0.18em] text-red-100">Start your journey</p><h2 class="mt-2 text-2xl font-extrabold tracking-tight sm:text-3xl">Ready to enroll at TMCNHS?</h2><p class="mt-3 text-sm leading-7 text-red-50/85">Review the enrollment process, prepare the required documents, and take the next step toward joining our school community.</p></div>
            <a href="{{ route('how-to-enroll') }}" class="relative mt-7 inline-flex min-h-12 items-center justify-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-extrabold text-[#a71930] shadow-md transition duration-300 hover:-translate-y-0.5 hover:bg-red-50 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#a71930] lg:mt-0">View Enrollment Process<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg></a>
        </div>
    </section>
</x-landing-layout>
