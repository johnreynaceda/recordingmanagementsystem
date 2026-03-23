<div class="max-w-6xl mx-auto space-y-6">
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Profile Header Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center space-x-6">
            <div class="h-24 w-24 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-4xl font-bold font-serif shadow-inner">
                {{ substr($firstname, 0, 1) }}{{ substr($lastname, 0, 1) }}
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">{{ $firstname }} {{ $lastname }}</h2>
                <div class="flex items-center text-gray-500 mt-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.242-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>{{ $address }}</span>
                </div>
            </div>
        </div>
        <button wire:click="$set('showModal', true)" class="mt-6 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-xl shadow-md transition duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l2 2m-4 4l2 2m-4 4l4-4m6-10.5L20.5 3.5l-1-1L5 16.5 4 20l3.5-1.5L15.5 8.5z" /></svg>
            Edit Profile
        </button>
    </div>

    <!-- Assigned Sections & Subjects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Sections Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 border-b border-gray-100 px-6 py-4 flex items-center">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Assigned Sections</h3>
            </div>
            <div class="p-6">
                @if(count($assignedSections) > 0)
                    <ul class="space-y-4">
                        @foreach($assignedSections as $section)
                            <li class="flex items-center relative p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50 transition duration-150">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $section->name ?? 'Unnamed Section' }}</p>
                                    <p class="text-sm text-gray-500">Grade Level: {{ $section->gradeLevel?->grade_level ?? 'N/A' }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="mt-2 text-sm">No sections assigned to you yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Subjects Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-50 border-b border-gray-100 px-6 py-4 flex items-center">
                <div class="bg-purple-100 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Assigned Subjects</h3>
            </div>
            <div class="p-6">
                @if(count($assignedSubjects) > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($assignedSubjects as $subject)
                            <div class="bg-gray-100 border border-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
                                {{ $subject->subject_name }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <p class="mt-2 text-sm">No subjects linked to your grade levels.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div x-data="{ open: @entangle('showModal') }" x-show="open" style="display: none;" class="fixed inset-0 flex items-center justify-center z-50">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm shadow-xl transition-opacity" @click="open = false"></div>
        
        <!-- Modal panel -->
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg z-10 transform overflow-hidden" x-transition>
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800 tracking-tight">Update Profile</h2>
                <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                    <input type="text" wire:model.defer="firstname" class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-100 transition py-2.5">
                    @error('firstname') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                    <input type="text" wire:model.defer="lastname" class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-100 transition py-2.5">
                    @error('lastname') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Address</label>
                    <input type="text" wire:model.defer="address" class="block w-full border-gray-300 rounded-xl shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-100 transition py-2.5">
                    @error('address') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 rounded-b-2xl">
                <button @click="open = false" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 py-2.5 px-5 rounded-xl font-medium transition shadow-sm">
                    Cancel
                </button>
                <button wire:click="update" class="bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-5 rounded-xl font-medium transition shadow-md flex items-center">
                    <svg wire:loading wire:target="update" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>
