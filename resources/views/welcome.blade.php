@section('title', 'Welcome')
<x-home-layout>
    <div>
        <section class="px-4 py-20 md:py-32 lg:py-48 relative">
            <div class="container max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-10 lg:gap-16">

                <!-- Left Content -->
                <div class="w-full md:w-7/12 text-center md:text-left">
                    <h1>
                        <span
                            class="block text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-main">
                            TRECE MARTIRES CITY
                        </span>
                        <span class="block text-lg sm:text-xl md:text-2xl lg:text-3xl text-gray-700">
                            National High School
                        </span>
                    </h1>

                    <p class="mt-6 mx-auto md:mx-0 text-base sm:text-lg lg:text-xl text-gray-600 max-w-md md:max-w-2xl">
                        It's never been easier to build beautiful websites that convey your message and tell your story.
                    </p>

                    <!-- Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row sm:justify-center md:justify-start gap-4">
                        <a href="#_"
                            class="px-6 py-3 bg-gray-100 text-main rounded-md hover:bg-gray-200 hover:text-gray-600 transition">
                            Mission
                        </a>
                        <a href="#_"
                            class="px-6 py-3 bg-gray-100 text-main rounded-md hover:bg-gray-200 hover:text-gray-600 transition">
                            Vision
                        </a>
                        <a href="#_"
                            class="px-6 py-3 bg-gray-100 text-main rounded-md hover:bg-gray-200 hover:text-gray-600 transition">
                            Goal
                        </a>
                    </div>
                </div>

                <!-- Right Logo -->
                <div class="w-full md:w-5/12 flex justify-center md:justify-end">
                    <div class="w-48 sm:w-60 md:w-72 lg:w-80 h-auto overflow-hidden text-gray-700 rounded-xl">
                        <div class="flex flex-col space-y-3">
                            <span class="font-bold">Login As</span>
                            <x-filament::button color="gray" size="lg" tag="a"
                                href="{{ route('student-login') }}">
                                Student Portal
                            </x-filament::button>
                            <x-filament::button color="gray" size="lg" tag="a"
                                href="{{ route('faculty-staff-login') }}">
                                Faculty & Staff Hub
                            </x-filament::button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-home-layout>
