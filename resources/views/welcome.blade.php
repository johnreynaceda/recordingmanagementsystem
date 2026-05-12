@section('title', 'Welcome')
<x-home-layout>
    <div class="relative overflow-hidden min-h-[calc(100vh-140px)] flex flex-col justify-center">
        <!-- Decorative animated blobs for vibrant aesthetics -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-red-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-10 right-10 w-72 h-72 bg-rose-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-10 left-1/3 w-72 h-72 bg-orange-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

        <section class="px-4 py-16 md:py-24 lg:py-32 relative z-10 w-full">
            <div class="container max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-16 lg:gap-20">

                <!-- Left Content: Hero Text & Cards -->
                <div class="w-full lg:w-3/5 text-center lg:text-left flex flex-col justify-center">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/60 border border-white/50 text-red-800 text-sm font-semibold mb-6 shadow-sm backdrop-blur-md transition-all hover:scale-105 hover:bg-white/80 w-max mx-auto lg:mx-0">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-600"></span>
                        </span>
                        Welcome to the official portal
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-gray-900 leading-[1.1]">
                        <span class="block bg-clip-text text-transparent bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 drop-shadow-sm pb-1">
                            TRECE MARTIRES CITY
                        </span>
                        <span class="block text-2xl sm:text-3xl md:text-4xl lg:text-5xl mt-3 text-gray-800 font-bold">
                            National High School
                        </span>
                    </h1>

                    <p class="mt-6 mx-auto lg:mx-0 text-base sm:text-lg md:text-xl text-gray-700 max-w-2xl leading-relaxed">
                        Empowering minds and shaping the future. Welcome to TMCNHS, where excellence in education meets character development to prepare 21st-century learners for global competitiveness.
                    </p>

                    <!-- Info Cards -->
                    <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-5 max-w-3xl mx-auto lg:mx-0">
                        <a href="#_" class="group relative overflow-hidden rounded-2xl bg-white/50 p-6 shadow-lg backdrop-blur-md border border-white/60 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:bg-white/80">
                            <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                            <div class="relative z-10 flex flex-col items-center lg:items-start">
                                <div class="mb-4 rounded-full bg-red-100 p-3 text-red-600 shadow-inner transition-all duration-300 group-hover:scale-110 group-hover:bg-red-600 group-hover:text-white group-hover:shadow-red-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-1">Mission</h3>
                                <p class="text-sm text-gray-600 text-center lg:text-left opacity-0 h-0 transition-all duration-300 group-hover:opacity-100 group-hover:h-auto mt-1">The Trece Martires City National High School has a mission to raise the quality of the learners and empowers them to be self-reliant, productive and responsible citizens.</p>
                            </div>
                        </a>
                        <a href="#_" class="group relative overflow-hidden rounded-2xl bg-white/50 p-6 shadow-lg backdrop-blur-md border border-white/60 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:bg-white/80">
                            <div class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                            <div class="relative z-10 flex flex-col items-center lg:items-start">
                                <div class="mb-4 rounded-full bg-rose-100 p-3 text-rose-600 shadow-inner transition-all duration-300 group-hover:scale-110 group-hover:bg-rose-600 group-hover:text-white group-hover:shadow-rose-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-1">Vision</h3>
                                <p class="text-sm text-gray-600 text-center lg:text-left opacity-0 h-0 transition-all duration-300 group-hover:opacity-100 group-hover:h-auto mt-1">The Trece Martires City National High School envisions learners to be high performing students, personally developed and committed for a productive life.</p>
                            </div>
                        </a>
                        <a href="#_" class="group relative overflow-hidden rounded-2xl bg-white/50 p-6 shadow-lg backdrop-blur-md border border-white/60 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:bg-white/80">
                            <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                            <div class="relative z-10 flex flex-col items-center lg:items-start">
                                <div class="mb-4 rounded-full bg-orange-100 p-3 text-orange-600 shadow-inner transition-all duration-300 group-hover:scale-110 group-hover:bg-orange-600 group-hover:text-white group-hover:shadow-orange-500/30">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-1">Values</h3>
                                <p class="text-sm text-gray-600 text-center lg:text-left opacity-0 h-0 transition-all duration-300 group-hover:opacity-100 group-hover:h-auto mt-1">Inculcate to the minds of every learners the Importance of different character traits with the aim of producing well-oriented and value oriented graduates.</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Right Login Panel (Glassmorphism) -->
                <div class="w-full lg:w-2/5 flex justify-center lg:justify-end perspective-1000 mt-8 lg:mt-0">
                    <div class="relative w-full max-w-md group/panel">
                        <!-- Glow effect behind the panel -->
                        <div class="absolute -inset-1 rounded-[2.5rem] bg-gradient-to-r from-red-600 via-rose-500 to-orange-600 opacity-20 blur-xl transition-all duration-1000 group-hover/panel:opacity-40 group-hover/panel:duration-500"></div>
                        
                        <div class="relative flex flex-col space-y-6 rounded-[2rem] bg-white/70 p-8 sm:p-10 shadow-2xl backdrop-blur-xl border border-white/80 transition-transform duration-500 hover:-translate-y-1">
                            
                            <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-gradient-to-br from-red-400 to-rose-400 rounded-full mix-blend-multiply filter blur-xl opacity-50 animate-pulse"></div>

                            <div class="text-center space-y-3 relative z-10">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-white to-gray-50 border border-white shadow-md mb-2 transform transition hover:rotate-12 duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Portal Access</h2>
                                <p class="text-sm text-gray-600 font-medium">Please select your designated portal to securely login to the system.</p>
                            </div>

                            <div class="flex flex-col space-y-4 pt-4 relative z-10">
                                <a href="{{ route('student-login') }}" class="group relative flex items-center justify-between w-full rounded-2xl bg-gradient-to-r from-red-600 to-rose-600 px-6 py-4 text-white font-semibold shadow-lg shadow-red-200 transition-all duration-300 hover:shadow-xl hover:shadow-red-300 hover:from-red-700 hover:to-rose-700 hover:-translate-y-1 overflow-hidden">
                                    <div class="absolute inset-0 bg-white/20 translate-x-[-100%] skew-x-[-15deg] transition-transform duration-700 group-hover:translate-x-[200%]"></div>
                                    <div class="flex items-center gap-3">
                                        <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6" />
                                            </svg>
                                        </div>
                                        <span class="text-lg">Student Portal</span>
                                    </div>
                                    <div class="bg-white/10 p-2 rounded-full transform transition-transform duration-300 group-hover:translate-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                                
                                <a href="{{ route('faculty-staff-login') }}" class="group relative flex items-center justify-between w-full rounded-2xl bg-white border-2 border-red-50 px-6 py-4 text-gray-700 font-semibold shadow-sm transition-all duration-300 hover:border-red-200 hover:shadow-md hover:shadow-red-100 hover:-translate-y-1">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-red-50 text-red-600 p-2 rounded-lg transition-colors group-hover:bg-red-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <span class="text-lg transition-colors group-hover:text-red-700">Faculty & Staff Hub</span>
                                    </div>
                                    <div class="text-gray-400 p-2 rounded-full transform transition-all duration-300 group-hover:translate-x-1 group-hover:text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <!-- Inline styles for custom animations to ensure they work without tailwind.config.js changes -->
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        .perspective-1000 {
            perspective: 1000px;
        }
    </style>
</x-home-layout>
