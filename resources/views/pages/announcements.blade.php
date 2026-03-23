<x-home-layout>
    @section('title', 'News & Announcements')
    
    <!-- Hero Section -->
    <div class="relative bg-main pt-20 pb-28 overflow-hidden rounded-b-[3rem] shadow-sm">
        <div class="absolute inset-0">
            <img src="{{ asset('images/bg.jpg') }}" class="w-full h-full object-cover opacity-10" alt="Background">
            <div class="absolute inset-0 bg-gradient-to-t from-main to-transparent mix-blend-multiply"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 drop-shadow-xl" style="font-family: 'Inter', sans-serif;">
                Stay Updated
            </h1>
            <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto font-medium leading-relaxed">
                Catch up on the latest news, announcements, and important updates from Trece Martires City National High School.
            </p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="bg-gray-50/50 min-h-[60vh] -mt-16 pb-24 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:public.announcement-list />
        </div>
    </div>
</x-home-layout>
