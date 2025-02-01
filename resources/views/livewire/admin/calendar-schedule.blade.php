<div>
    <div class="grid grid-cols-4 gap-5">
        @if (auth()->user()->user_type == 'admin')
            <div class="">
                <div>
                    {{ $this->form }}
                </div>
                <div class="mt-3">
                    <x-button label="Save Event" negative class="font-semibold uppercase" right-icon="arrow-right"
                        wire:click="saveEvent" />
                </div>
            </div>
        @endif
        <div class="{{ auth()->user()->user_type != 'admin' ? 'col-span-4' : '' }} bg-white p-5 rounded-xl col-span-3"
            x-data="calendarComponent(@entangle('events'))">
            <div id="calendar"></div>

            <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
            <script src="https://unpkg.com/@popperjs/core@2"></script>
            <script src="https://unpkg.com/tippy.js@6"></script>
            <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css">
            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('calendarComponent', (events) => ({
                        events: events,
                        calendar: null,

                        init() {
                            let calendarEl = document.getElementById('calendar');

                            this.calendar = new FullCalendar.Calendar(calendarEl, {
                                initialView: 'dayGridMonth',
                                events: this.events,
                                displayEventTime: false, // Hide time in event display

                                eventMouseEnter: (info) => {
                                    // Create tooltip content dynamically
                                    const tooltipContent = `
                            <div class="p-2 bg-white relative z-50 text-black border border-red-500 rounded shadow">
                                <strong>${info.event.title}</strong><br>
                                ${info.event.start.toDateString()}
                                ${info.event.end ? ` - ${info.event.end.toDateString()}` : ''}
                            </div>
                        `;

                                    // Add tooltip to DOM
                                    let tooltip = document.createElement('div');
                                    tooltip.innerHTML = tooltipContent;
                                    tooltip.id = 'event-tooltip';
                                    tooltip.style.position = 'absolute';
                                    tooltip.style.top = `${info.jsEvent.pageY + 10}px`;
                                    tooltip.style.left = `${info.jsEvent.pageX + 10}px`;
                                    document.body.appendChild(tooltip);
                                },

                                eventMouseLeave: () => {
                                    // Remove tooltip when mouse leaves
                                    let tooltip = document.getElementById('event-tooltip');
                                    if (tooltip) {
                                        tooltip.remove();
                                    }
                                },
                            });

                            this.calendar.render();

                            this.$watch('events', (newEvents) => {
                                this.calendar.removeAllEvents();
                                this.calendar.addEventSource(newEvents);
                            });
                        },
                    }));
                });
            </script>
        </div>
    </div>
</div>
