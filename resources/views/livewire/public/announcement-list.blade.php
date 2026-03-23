<div class="space-y-12">
    @if($announcements->count() > 0)
        <!-- Featured Announcement (First one) -->
        @php $featured = $announcements->first(); @endphp
        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden transition-all duration-500 hover:shadow-2xl group/card">
            <div class="flex flex-col md:flex-row h-full">
                @if ($featured->image)
                    <div class="w-full md:w-1/2 lg:w-3/5 h-80 md:h-[28rem] overflow-hidden relative group-hover/card:shadow-inner transition-shadow">
                        <img src="{{ asset('storage/' . $featured->image) }}" alt="{{ $featured->title }}" class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover/card:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-black/80 via-black/20 md:via-black/40 to-transparent"></div>
                        <span class="absolute top-6 left-6 md:top-8 md:left-8 bg-red-600/90 backdrop-blur-sm text-white text-xs font-bold uppercase tracking-widest py-2 px-4 rounded-full shadow-[0_0_15px_rgba(220,38,38,0.5)] border border-white/20">Featured Update</span>
                    </div>
                @endif
                <div class="w-full {{ $featured->image ? 'md:w-1/2 lg:w-2/5 p-8 md:p-12' : 'p-10 md:p-20 text-center mx-auto max-w-4xl' }} flex flex-col justify-center bg-white relative z-10 transition-colors">
                    @if(!$featured->image)
                        <span class="inline-block mb-8 mx-auto bg-red-600/10 text-red-600 border border-red-600/20 text-xs font-bold uppercase tracking-widest py-2 px-6 rounded-full">Featured Update</span>
                    @endif
                    <div class="text-sm font-semibold text-main mb-6 flex items-center {{ $featured->image ? '' : 'justify-center' }} gap-2 opacity-80">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                        {{ $featured->created_at->format('F d, Y') }}
                    </div>
                    <h3 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-[1.15] tracking-tight">{{ $featured->title }}</h3>
                    <div class="text-gray-600 text-lg leading-relaxed whitespace-pre-line line-clamp-6 {{ $featured->image ? '' : 'max-w-2xl mx-auto' }}">
                        {{ $featured->content }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid for the rest -->
        @if($announcements->count() > 1)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
                @foreach ($announcements->skip(1) as $announcement)
                    <div class="bg-white rounded-3xl shadow-md hover:shadow-2xl border border-gray-100 overflow-hidden flex flex-col transition-all duration-300 hover:-translate-y-2 group">
                        @if ($announcement->image)
                            <div class="w-full h-64 overflow-hidden relative">
                                <img src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent opacity-60 transition-opacity group-hover:opacity-80"></div>
                            </div>
                        @else
                            <div class="w-full h-4 bg-gradient-to-r from-main to-red-400"></div>
                        @endif
                        <div class="p-8 flex-1 flex flex-col">
                            <div class="text-xs font-semibold text-main mb-4 flex items-center gap-2 bg-main/5 w-fit px-3 py-1.5 rounded-full border border-main/10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $announcement->created_at->format('M d, Y') }}
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4 leading-tight group-hover:text-main transition-colors decoration-2 decoration-main underline-offset-4 group-hover:underline">{{ $announcement->title }}</h3>
                            <div class="text-gray-600 text-[15px] leading-relaxed whitespace-pre-line flex-1 line-clamp-4">
                                {{ $announcement->content }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @else
        <div class="text-center py-32 bg-white rounded-[3rem] border border-gray-100 shadow-sm mx-auto max-w-3xl relative overflow-hidden">
            <div class="absolute inset-0 bg-gray-50/50 -z-10"></div>
            <div class="mx-auto w-28 h-28 bg-red-50 rounded-full flex items-center justify-center mb-8 border-8 border-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone text-red-500"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
            </div>
            <h3 class="text-4xl font-black text-gray-900 mb-4 tracking-tight">No Announcements Yet</h3>
            <p class="text-gray-500 text-xl max-w-md mx-auto font-medium">Check back later for important updates and news from the administration.</p>
        </div>
    @endif
</div>
