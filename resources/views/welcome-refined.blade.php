@section('title', 'Welcome')

<x-home-layout>
    <div class="relative isolate overflow-hidden rounded-[2rem] border border-white/70 bg-slate-50 shadow-sm shadow-slate-300/40">
        <div class="pointer-events-none absolute inset-0 -z-10">
            <div class="absolute -right-28 -top-32 h-96 w-96 rounded-full bg-red-100/80 blur-3xl"></div>
            <div class="absolute -bottom-44 -left-32 h-96 w-96 rounded-full bg-slate-200/70 blur-3xl"></div>
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-main/40 to-transparent"></div>
        </div>

        <section class="mx-auto grid min-h-[calc(100vh-180px)] w-full max-w-7xl items-center gap-12 px-5 py-12 sm:px-8 sm:py-16 lg:grid-cols-12 lg:gap-14 lg:px-10 lg:py-20 xl:px-12">
            <div class="lg:col-span-7">
                <div class="mx-auto max-w-3xl text-center lg:mx-0 lg:text-left">
                    <div class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-white px-3.5 py-2 text-xs font-bold uppercase tracking-[0.13em] text-main shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-main opacity-40"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-main"></span>
                        </span>
                        Welcome to the official portal
                    </div>

                    <h1 class="mt-6 tracking-tight text-slate-950">
                        <span class="block text-4xl font-bold leading-[1.05] sm:text-5xl md:text-6xl xl:text-7xl">
                            TRECE MARTIRES CITY
                        </span>
                        <span class="mt-3 block text-2xl font-semibold text-main sm:text-3xl md:text-4xl">
                            National High School
                        </span>
                    </h1>

                    <p class="mx-auto mt-6 max-w-2xl text-base font-medium leading-7 text-slate-600 sm:text-lg sm:leading-8 lg:mx-0">
                        Empowering minds and shaping the future. Welcome to TMCNHS, where excellence in education meets character development to prepare 21st-century learners for global competitiveness.
                    </p>
                </div>

                <div class="mx-auto mt-9 grid max-w-3xl gap-4 sm:grid-cols-3 lg:mx-0">
                    <a href="#_" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-red-200 hover:shadow-lg hover:shadow-red-100/60 focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
                        <div class="flex items-center gap-3 sm:block">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-main ring-1 ring-red-100 transition group-hover:bg-main group-hover:text-white">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="8.25" />
                                    <circle cx="12" cy="12" r="4.5" />
                                    <circle cx="12" cy="12" r="1" fill="currentColor" stroke="none" />
                                </svg>
                            </span>
                            <h2 class="text-lg font-bold text-slate-900 sm:mt-4">Mission</h2>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            The Trece Martires City National High School has a mission to raise the quality of the learners and empowers them to be self-reliant, productive and responsible citizens.
                        </p>
                    </a>

                    <a href="#_" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-red-200 hover:shadow-lg hover:shadow-red-100/60 focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
                        <div class="flex items-center gap-3 sm:block">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-main ring-1 ring-red-100 transition group-hover:bg-main group-hover:text-white">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.75 12s3.25-5.5 9.25-5.5 9.25 5.5 9.25 5.5-3.25 5.5-9.25 5.5S2.75 12 2.75 12Z" />
                                    <circle cx="12" cy="12" r="2.5" />
                                </svg>
                            </span>
                            <h2 class="text-lg font-bold text-slate-900 sm:mt-4">Vision</h2>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            The Trece Martires City National High School envisions learners to be high performing students, personally developed and committed for a productive life.
                        </p>
                    </a>

                    <a href="#_" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-red-200 hover:shadow-lg hover:shadow-red-100/60 focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
                        <div class="flex items-center gap-3 sm:block">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-main ring-1 ring-red-100 transition group-hover:bg-main group-hover:text-white">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m12 3 2.45 4.97 5.48.8-3.97 3.86.94 5.46L12 15.51l-4.9 2.58.94-5.46-3.97-3.86 5.48-.8L12 3Z" />
                                </svg>
                            </span>
                            <h2 class="text-lg font-bold text-slate-900 sm:mt-4">Values</h2>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            Inculcate to the minds of every learners the Importance of different character traits with the aim of producing well-oriented and value oriented graduates.
                        </p>
                    </a>
                </div>
            </div>

            <div class="mx-auto w-full max-w-md lg:col-span-5 lg:ml-auto">
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-300/40">
                    <div class="relative overflow-hidden bg-gradient-to-br from-red-600 to-main px-7 py-8 text-white sm:px-8">
                        <img src="{{ asset('images/bg.jpg') }}" class="absolute inset-0 h-full w-full object-cover opacity-10" alt="">
                        <div class="absolute -right-16 -top-16 h-44 w-44 rounded-full bg-white/10 blur-2xl"></div>

                        <div class="relative">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/20 backdrop-blur-sm">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 10.5V7.75a4.5 4.5 0 0 1 9 0v2.75m-10.25 0h11.5A1.75 1.75 0 0 1 19.5 12.25v7A1.75 1.75 0 0 1 17.75 21H6.25a1.75 1.75 0 0 1-1.75-1.75v-7a1.75 1.75 0 0 1 1.75-1.75ZM12 14.5v2.75" />
                                </svg>
                            </span>
                            <p class="mt-6 text-xs font-bold uppercase tracking-[0.16em] text-white/70">Secure sign in</p>
                            <h2 class="mt-1 text-3xl font-bold tracking-tight">Portal Access</h2>
                            <p class="mt-3 max-w-sm text-sm font-medium leading-6 text-white/80">
                                Please select your designated portal to securely login to the system.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3 p-5 sm:p-6">
                        <a href="{{ route('student-login') }}"
                            class="group flex w-full items-center gap-4 rounded-2xl bg-slate-950 px-4 py-4 text-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:bg-slate-800 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-slate-950 focus:ring-offset-2">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10 text-white ring-1 ring-white/10">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m3 8.5 9-4.5 9 4.5-9 4.5-9-4.5Zm3 2v5.25c3.5 2.5 8.5 2.5 12 0V10.5M21 8.5v6" />
                                </svg>
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-base font-bold">Student Portal</span>
                            </span>
                            <svg class="h-5 w-5 text-slate-400 transition-transform group-hover:translate-x-1 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
                            </svg>
                        </a>

                        <a href="{{ route('faculty-staff-login') }}"
                            class="group flex w-full items-center gap-4 rounded-2xl border border-slate-200 bg-white px-4 py-4 text-slate-800 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-red-200 hover:shadow-lg hover:shadow-red-100/60 focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-50 text-main ring-1 ring-red-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V5.5A2.5 2.5 0 0 1 10.5 3h3A2.5 2.5 0 0 1 16 5.5V7M5.25 7h13.5a1.75 1.75 0 0 1 1.75 1.75v9.5A1.75 1.75 0 0 1 18.75 20H5.25a1.75 1.75 0 0 1-1.75-1.75v-9.5A1.75 1.75 0 0 1 5.25 7ZM3.5 12a22.5 22.5 0 0 0 17 0M12 11.5v2" />
                                </svg>
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-base font-bold transition-colors group-hover:text-main">Faculty & Staff Hub</span>
                            </span>
                            <svg class="h-5 w-5 text-slate-400 transition-all group-hover:translate-x-1 group-hover:text-main" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
        body { overflow-y: auto !important; }

        @media (prefers-reduced-motion: reduce) {
            .animate-ping { animation: none !important; }
        }
    </style>
</x-home-layout>
