<div class="mx-auto max-w-7xl space-y-6">
    <div class="overflow-hidden rounded-2xl border border-red-100 bg-white shadow-sm">
        <div class="relative bg-slate-950 px-5 py-6 text-white sm:px-8">
            <div class="absolute inset-y-0 right-0 hidden w-1/2 bg-gradient-to-l from-main/30 to-transparent md:block"></div>

            <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-red-200">Document Requests</p>
                    <h1 class="mt-2 text-2xl font-bold sm:text-3xl">Request school records</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-300">
                        Submit a request for SF 10 or SF 9 and track its review status by academic year.
                    </p>
                </div>

                <button type="button" wire:click="$set('showModal', true)"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-main px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                    New Request
                </button>
            </div>
        </div>

        <div class="grid gap-4 border-b border-slate-100 bg-white p-5 sm:grid-cols-2 lg:grid-cols-4 lg:p-6">
            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Academic Year</p>
                <select wire:model.live="selected_academic_year_id"
                    class="mt-2 w-full rounded-lg border-slate-200 bg-white text-sm font-semibold text-slate-800 shadow-sm focus:border-main focus:ring-main">
                    @foreach ($academic_years as $year)
                        <option value="{{ $year->id }}">{{ $year->name }} {{ $year->is_active ? '(Active)' : '' }}</option>
                    @endforeach
                </select>
            </div>

            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Requests</p>
                <p class="mt-2 text-3xl font-bold text-slate-950">{{ number_format($total_requests) }}</p>
            </div>

            <div class="rounded-xl border border-amber-100 bg-amber-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-amber-700">Pending</p>
                <p class="mt-2 text-3xl font-bold text-amber-800">{{ number_format($pending_requests) }}</p>
            </div>

            <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Approved</p>
                <p class="mt-2 text-3xl font-bold text-emerald-800">{{ number_format($approved_requests) }}</p>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            <div class="hidden overflow-hidden rounded-xl border border-slate-200 lg:block">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Request</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Contact</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Details</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Requested</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-slate-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($requests as $request)
                            <tr class="transition hover:bg-slate-50">
                                <td class="px-4 py-4">
                                    <p class="font-bold text-slate-900">{{ $request->name }}</p>
                                    <p class="mt-1 text-sm font-semibold text-main">{{ $request->option }}</p>
                                </td>
                                <td class="px-4 py-4 text-sm text-slate-600">
                                    <p class="font-medium text-slate-800">{{ $request->email_address }}</p>
                                    <p class="mt-1">{{ $request->phone_number }}</p>
                                </td>
                                <td class="max-w-md px-4 py-4 text-sm text-slate-600">
                                    <p><span class="font-semibold text-slate-800">Last Year Attended:</span> {{ $request->lastYearAttended->name ?? 'N/A' }}</p>
                                    <p class="mt-1"><span class="font-semibold text-slate-800">Section:</span> {{ $request->section->name ?? 'N/A' }}</p>
                                    <p class="mt-2">
                                    {{ $request->additional_information ?: 'No additional information provided.' }}
                                    </p>
                                </td>
                                <td class="px-4 py-4 text-sm font-medium text-slate-700">
                                    {{ $request->created_at->format('M d, Y') }}
                                    <p class="mt-1 text-xs font-normal text-slate-400">{{ $request->created_at->format('g:i A') }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    @if ($request->status === 'approved')
                                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-emerald-700">Approved</span>
                                    @elseif ($request->status === 'declined')
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-red-700">Declined</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-amber-700">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center">
                                    <p class="text-sm font-semibold text-slate-700">No requests found</p>
                                    <p class="mt-1 text-sm text-slate-500">Create a request or choose another academic year.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="space-y-4 lg:hidden">
                @forelse ($requests as $request)
                    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-bold text-slate-950">{{ $request->option }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $request->created_at->format('M d, Y, g:i A') }}</p>
                            </div>

                            @if ($request->status === 'approved')
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">Approved</span>
                            @elseif ($request->status === 'declined')
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">Declined</span>
                            @else
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">Pending</span>
                            @endif
                        </div>

                        <div class="mt-4 grid gap-3 text-sm text-slate-600">
                            <p><span class="font-semibold text-slate-800">Email:</span> {{ $request->email_address }}</p>
                            <p><span class="font-semibold text-slate-800">Phone:</span> {{ $request->phone_number }}</p>
                            <p><span class="font-semibold text-slate-800">Last Year Attended:</span> {{ $request->lastYearAttended->name ?? 'N/A' }}</p>
                            <p><span class="font-semibold text-slate-800">Section:</span> {{ $request->section->name ?? 'N/A' }}</p>
                            <p><span class="font-semibold text-slate-800">Details:</span> {{ $request->additional_information ?: 'No additional information provided.' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                        <p class="text-sm font-semibold text-slate-700">No requests found</p>
                        <p class="mt-1 text-sm text-slate-500">Create a request or choose another academic year.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div x-data="{ open: @entangle('showModal') }" x-show="open" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        role="dialog" aria-modal="true">
        <div x-show="open" x-transition.opacity class="absolute inset-0 bg-slate-950/60" @click="open = false"></div>

        <div x-show="open" x-transition
            class="relative max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl">
            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-main">New Request</p>
                        <h2 class="mt-1 text-xl font-bold text-slate-950">Request Form</h2>
                    </div>

                    <button type="button" @click="open = false"
                        class="flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-100 hover:text-slate-900">
                        <span class="sr-only">Close request form</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <form wire:submit.prevent="save" class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 sm:p-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700">Full Name</label>
                    <input type="text" id="name" wire:model="name"
                        class="mt-2 block w-full rounded-lg border-slate-200 shadow-sm focus:border-main focus:ring-main"
                        required>
                    @error('name')
                        <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                    <input type="email" id="email" wire:model="email_address"
                        class="mt-2 block w-full rounded-lg border-slate-200 shadow-sm focus:border-main focus:ring-main"
                        required>
                    @error('email_address')
                        <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700">Phone Number</label>
                    <input type="tel" id="phone" wire:model="phone_number"
                        class="mt-2 block w-full rounded-lg border-slate-200 shadow-sm focus:border-main focus:ring-main"
                        placeholder="Enter your phone number" required>
                    @error('phone_number')
                        <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="options" class="block text-sm font-semibold text-slate-700">Document Type</label>
                    <select id="options" wire:model="option"
                        class="mt-2 block w-full rounded-lg border-slate-200 shadow-sm focus:border-main focus:ring-main"
                        required>
                        <option value="">Select a document</option>
                        <option value="SF 10 (Permanent Record)">SF 10 (Permanent Record)</option>
                        <option value="SF 9 (Report Card)">SF 9 (Report Card)</option>
                    </select>
                    @error('option')
                        <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="last_year_attended" class="block text-sm font-semibold text-slate-700">Last Year Attended</label>
                    <select id="last_year_attended" wire:model.live="last_year_attended_id"
                        class="mt-2 block w-full rounded-lg border-slate-200 shadow-sm focus:border-main focus:ring-main"
                        required>
                        <option value="">Select academic year</option>
                        @foreach ($request_academic_years as $year)
                            <option value="{{ $year->id }}">{{ $year->name }} {{ $year->is_active ? '(Active)' : '' }}</option>
                        @endforeach
                    </select>
                    @error('last_year_attended_id')
                        <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="section_id" class="block text-sm font-semibold text-slate-700">Section</label>
                    <select id="section_id" wire:model="section_id"
                        class="mt-2 block w-full rounded-lg border-slate-200 shadow-sm focus:border-main focus:ring-main"
                        required>
                        <option value="">Select section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                    @error('section_id')
                        <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="message" class="block text-sm font-semibold text-slate-700">Additional Information</label>
                    <textarea id="message" wire:model="additional_information" rows="4"
                        class="mt-2 block w-full rounded-lg border-slate-200 shadow-sm focus:border-main focus:ring-main"
                        placeholder="Add details that may help the registrar process your request."></textarea>
                    @error('additional_information')
                        <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:col-span-2 sm:flex-row sm:justify-end">
                    <button type="button" @click="open = false"
                        class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-main px-4 py-2.5 text-sm font-bold text-white transition hover:bg-red-600 disabled:cursor-wait disabled:opacity-70"
                        wire:loading.attr="disabled" wire:target="save">
                        <span wire:loading.remove wire:target="save">Submit Request</span>
                        <span wire:loading wire:target="save">Submitting...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
