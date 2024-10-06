@section('title', 'Welcome')
<x-home-layout>
    <div>
        <section class="px-2 h-screen py-48 relative md:px-0">
            <div class="container items-center max-w-6xl px-8 mx-auto xl:px-5">
                <div class="flex flex-wrap items-center sm:-mx-3">
                    <div class="w-full md:w-1/2 md:px-3">
                        <div
                            class="w-full pb-6 space-y-6 sm:max-w-md lg:max-w-lg md:space-y-4 lg:space-y-8 xl:space-y-9 sm:pr-5 lg:pr-0 md:pb-0">
                            <h1 class="text-center">
                                <span
                                    class="block xl:inline text-4xl font-extrabold  tracking-tight text-main sm:text-5xl md:text-4xl lg:text-5xl xl:text-5xl">TRECE
                                    MARTIRES CITY</span>
                                <span class="block xl:inline text-2xl text-gray-700">National High School</span>

                            </h1>

                            <p class="mx-auto text-base text-gray-600 sm:max-w-md lg:text-xl md:max-w-3xl">It's
                                never
                                been easier to build beautiful websites that convey your message and tell your
                                story.
                            </p>
                            <div class="relative flex flex-col sm:flex-row sm:space-x-4 sm:justify-center">

                                <a href="#_"
                                    class="flex items-center px-6 py-3 text-main bg-gray-100 rounded-md hover:bg-gray-200 hover:text-gray-600"
                                    data-rounded="rounded-md">
                                    Mission
                                </a>
                                <a href="#_"
                                    class="flex items-center px-6 py-3 text-main bg-gray-100 rounded-md hover:bg-gray-200 hover:text-gray-600"
                                    data-rounded="rounded-md">
                                    Vision
                                </a>
                                <a href="#_"
                                    class="flex items-center px-6 py-3 text-main bg-gray-100 rounded-md hover:bg-gray-200 hover:text-gray-600"
                                    data-rounded="rounded-md">
                                    Goal
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="w-full h-auto overflow-hidden " data-rounded="rounded-xl"
                            data-rounded-max="rounded-full">
                            <img src="{{ asset('images/tmcnhs_logo.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-home-layout>
