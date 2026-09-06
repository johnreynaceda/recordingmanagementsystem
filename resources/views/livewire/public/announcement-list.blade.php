<div class="mx-auto max-w-6xl space-y-10">
    @if ($featured)
        <article class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            @if ($featured->image)
                <div class="flex h-72 items-center justify-center border-b border-gray-200 bg-gray-50 p-3 sm:h-[30rem] sm:p-5">
                    <img src="{{ asset('storage/' . $featured->image) }}" alt="Image for {{ $featured->title }}"
                        class="h-full w-full object-contain">
                </div>
            @endif

            <div class="px-6 py-7 sm:px-10 sm:py-9">
                <div class="flex flex-wrap items-center gap-x-3 gap-y-2 text-sm">
                    <span class="font-bold uppercase tracking-wider text-main">Featured</span>
                    <span class="h-1 w-1 rounded-full bg-gray-300" aria-hidden="true"></span>
                    <time datetime="{{ $featured->created_at->toDateString() }}" class="text-gray-500">
                        {{ $featured->created_at->format('F d, Y') }}
                    </time>
                </div>

                <h2 class="mt-4 max-w-4xl text-2xl font-bold leading-tight tracking-tight text-gray-950 sm:text-3xl">
                    {{ $featured->title }}
                </h2>

                <div class="mt-5 max-w-4xl whitespace-pre-wrap break-words [overflow-wrap:anywhere] text-base leading-8 text-gray-700">
                    {{ $featured->content }}
                </div>
            </div>
        </article>

        @if ($announcements->isNotEmpty())
            <section>
                <div class="mb-5 flex items-center gap-3">
                    <span class="h-6 w-1 rounded-full bg-main"></span>
                    <h2 class="text-xl font-bold text-gray-900">More announcements</h2>
                </div>

                <div class="space-y-5">
                    @foreach ($announcements as $announcement)
                        <article wire:key="announcement-{{ $announcement->id }}"
                            class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                            <div class="flex flex-col sm:flex-row">
                                @if ($announcement->image)
                                    <div class="flex h-64 shrink-0 items-center justify-center border-b border-gray-200 bg-gray-50 p-3 sm:h-auto sm:min-h-64 sm:w-72 sm:border-b-0 sm:border-r lg:w-80">
                                        <img src="{{ asset('storage/' . $announcement->image) }}"
                                            alt="Image for {{ $announcement->title }}"
                                            class="h-full max-h-80 w-full object-contain">
                                    </div>
                                @else
                                    <div class="flex h-20 shrink-0 items-center justify-center border-b border-red-100 bg-red-50 text-main sm:h-auto sm:min-h-64 sm:w-24 sm:border-b-0 sm:border-r lg:w-28">
                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.7"
                                            viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m3 11 18-5v12L3 14v-3Zm8.6 5.8a3 3 0 1 1-5.8-1.6" />
                                        </svg>
                                    </div>
                                @endif

                                <div class="min-w-0 flex-1 p-6 sm:p-8">
                                    <time datetime="{{ $announcement->created_at->toDateString() }}"
                                        class="text-sm font-medium text-gray-500">
                                        {{ $announcement->created_at->format('F d, Y') }}
                                    </time>

                                    <h3 class="mt-2 text-xl font-bold leading-snug text-gray-900 sm:text-2xl">
                                        {{ $announcement->title }}
                                    </h3>

                                    <div class="mt-4 whitespace-pre-wrap break-words [overflow-wrap:anywhere] text-base leading-7 text-gray-700">
                                        {{ $announcement->content }}
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($hasMore)
                    <div class="mt-8 flex justify-center">
                        <button type="button" wire:click="loadMore" wire:loading.attr="disabled" wire:target="loadMore"
                            class="inline-flex min-w-40 items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-5 py-3 text-sm font-bold text-main shadow-sm transition hover:border-main hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-main focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60">
                            <svg wire:loading wire:target="loadMore" class="h-4 w-4 animate-spin" viewBox="0 0 24 24"
                                fill="none" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4" />
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 0 1 8-8V0A12 12 0 0 0 0 12h4Z" />
                            </svg>
                            <span wire:loading.remove wire:target="loadMore">Load more announcements</span>
                            <span wire:loading wire:target="loadMore">Loading...</span>
                        </button>
                    </div>
                @endif
            </section>
        @endif
    @else
        <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">
            <span class="mx-auto inline-flex rounded-full bg-red-50 p-4 text-main">
                <svg class="h-9 w-9" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m3 11 18-5v12L3 14v-3Zm8.6 5.8a3 3 0 1 1-5.8-1.6" />
                </svg>
            </span>
            <h2 class="mt-4 text-xl font-bold text-gray-900">No announcements yet</h2>
            <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                Check back later for important updates from the administration.
            </p>
        </div>
    @endif
</div>
