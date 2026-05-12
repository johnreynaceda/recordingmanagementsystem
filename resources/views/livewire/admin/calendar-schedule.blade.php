<div class="space-y-6">
    <div class="overflow-hidden rounded-2xl border border-red-100 bg-white shadow-sm">
        <div class="relative bg-slate-950 px-5 py-6 text-white sm:px-6">
            <div class="absolute inset-y-0 right-0 hidden w-1/2 bg-gradient-to-l from-main/30 to-transparent lg:block"></div>

            <div class="relative flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-red-200">{{ $calendar_copy['eyebrow'] }}</p>
                    <h2 class="mt-2 text-2xl font-bold sm:text-3xl">{{ $calendar_copy['title'] }}</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-300">
                        {{ $calendar_copy['description'] }}
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-3 text-center sm:min-w-96">
                    <div class="rounded-xl border border-white/10 bg-white/10 px-4 py-3 backdrop-blur">
                        <p class="text-2xl font-bold">{{ number_format($total_events) }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-300">Total</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-amber-400/15 px-4 py-3 backdrop-blur">
                        <p class="text-2xl font-bold text-amber-100">{{ number_format($upcoming_events_count) }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-amber-100/80">Upcoming</p>
                    </div>
                    <div class="rounded-xl border border-white/10 bg-red-400/15 px-4 py-3 backdrop-blur">
                        <p class="text-2xl font-bold text-red-100">{{ number_format($this_month_events_count) }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-red-100/80">This Month</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 bg-slate-50 p-4 lg:grid-cols-[22rem_minmax(0,1fr)] lg:p-6">
            @if (auth()->user()->user_type == 'admin')
                <aside class="space-y-4">
                    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="mb-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-main">Create Event</p>
                            <h3 class="mt-1 text-lg font-bold text-slate-950">Add a schedule</h3>
                        </div>

                        {{ $this->form }}

                        <button type="button" wire:click="saveEvent" wire:loading.attr="disabled" wire:target="saveEvent"
                            class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-main px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-red-600 disabled:cursor-wait disabled:opacity-70">
                            <span wire:loading.remove wire:target="saveEvent">Save Event</span>
                            <span wire:loading wire:target="saveEvent">Saving...</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="mb-4 flex items-center justify-between gap-3">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Next Events</p>
                                <h3 class="mt-1 font-bold text-slate-950">Upcoming</h3>
                            </div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-50 text-main">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 2v4" />
                                    <path d="M16 2v4" />
                                    <rect width="18" height="18" x="3" y="4" rx="2" />
                                    <path d="M3 10h18" />
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @forelse ($upcoming_events as $event)
                                <div class="rounded-lg border border-slate-100 bg-slate-50 p-3">
                                    <p class="line-clamp-2 text-sm font-bold text-slate-900">{{ $event->title }}</p>
                                    <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-500">
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                                        @if ($event->start_date !== $event->end_date)
                                            - {{ \Carbon\Carbon::parse($event->end_date)->format('M d, Y') }}
                                        @endif
                                    </p>
                                </div>
                            @empty
                                <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4 text-center">
                                    <p class="text-sm font-semibold text-slate-600">No upcoming events yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </aside>
            @endif

            <section
                class="{{ auth()->user()->user_type != 'admin' ? 'lg:col-span-2' : '' }} calendar-shell rounded-xl border border-slate-200 bg-white p-3 shadow-sm sm:p-5"
                x-data="calendarComponent(@entangle('events'))">
                <div id="calendar" wire:ignore></div>
            </section>
        </div>
    </div>

    @once
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('calendarComponent', (events) => ({
                    events,
                    calendar: null,
                    tooltip: null,

                    init() {
                        const calendarEl = this.$el.querySelector('#calendar');

                        this.calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            events: this.events,
                            displayEventTime: false,
                            height: 'auto',
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,listWeek',
                            },
                            buttonText: {
                                today: 'Today',
                                month: 'Month',
                                list: 'List',
                            },
                            eventClassNames: 'school-calendar-event',
                            eventMouseEnter: (info) => this.showTooltip(info),
                            eventMouseLeave: () => this.hideTooltip(),
                        });

                        this.calendar.render();

                        this.$watch('events', (newEvents) => {
                            this.calendar.removeAllEvents();
                            this.calendar.addEventSource(newEvents);
                        });
                    },

                    showTooltip(info) {
                        this.hideTooltip();

                        const endDate = info.event.extendedProps.displayEnd;
                        const startDate = info.event.start ? info.event.start.toDateString() : '';

                        this.tooltip = document.createElement('div');
                        this.tooltip.className = 'calendar-tooltip';
                        this.tooltip.innerHTML = `
                            <p class="text-xs font-semibold uppercase tracking-wide text-red-500">Event</p>
                            <p class="mt-1 font-bold text-slate-950">${info.event.title}</p>
                            <p class="mt-1 text-sm text-slate-600">${startDate}${endDate ? ` - ${endDate}` : ''}</p>
                        `;
                        this.tooltip.style.top = `${info.jsEvent.pageY + 12}px`;
                        this.tooltip.style.left = `${info.jsEvent.pageX + 12}px`;
                        document.body.appendChild(this.tooltip);
                    },

                    hideTooltip() {
                        if (this.tooltip) {
                            this.tooltip.remove();
                            this.tooltip = null;
                        }
                    },
                }));
            });
        </script>
    @endonce
</div>
