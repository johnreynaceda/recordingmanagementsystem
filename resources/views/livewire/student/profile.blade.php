<div class="mx-auto max-w-7xl space-y-5 sm:space-y-8">
    <!-- Header -->
    <div class="relative flex items-center justify-between overflow-hidden rounded-2xl bg-gradient-to-r from-red-600 to-red-800 p-5 text-white shadow-xl sm:rounded-3xl sm:p-8">
        <div class="relative z-10">
            <h2 class="text-2xl font-extrabold tracking-tight sm:text-3xl">Student Profile</h2>
            <p class="mt-2 text-sm font-medium text-red-100 sm:text-base">Manage your personal information and student records.</p>
        </div>
        <div class="relative z-10 hidden md:block">
            <svg class="w-16 h-16 text-red-200 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        </div>
        <!-- Decorative subtle shapes -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 rounded-full bg-red-300 opacity-10 blur-xl"></div>
    </div>

    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" class="flex items-start justify-between gap-3 rounded-xl border-l-4 border-green-500 bg-green-50 p-4 shadow-sm transition-all duration-500">
            <div class="flex min-w-0">
                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-700 transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white/80 shadow-lg backdrop-blur-xl sm:rounded-3xl">
        
        <div class="p-4 sm:p-8 lg:p-12">
            @if($isEditing)
                <form wire:submit.prevent="save">
                    <div class="lg:flex lg:gap-12">
                        <!-- Left Side: Profile Picture Edit -->
                        <div class="mb-10 flex flex-col items-center lg:mb-0 lg:w-1/3">
                            <div class="group relative h-36 w-36 cursor-pointer overflow-hidden rounded-full border-4 border-white shadow-2xl ring-4 ring-red-50 transition-all duration-300 hover:ring-red-100 sm:h-48 sm:w-48">
                                @if ($new_image)
                                    <img src="{{ $new_image->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif ($student->image_path)
                                    <img src="{{ asset('storage/' . $student->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                @endif
                                
                                <label for="photo-upload" class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer backdrop-blur-sm">
                                    <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16a2 2 0 012-2h3l2-2h4l2 2h3a2 2 0 012 2v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16v-4m0 0l-3 3m3-3l3 3"></path></svg>
                                    <span class="text-white text-sm font-medium">Change Photo</span>
                                </label>
                                <input type="file" id="photo-upload" wire:model="new_image" class="hidden" accept="image/*">
                            </div>

                            <label for="photo-upload" class="mt-5 inline-flex w-full cursor-pointer items-center justify-center rounded-xl border border-red-200 bg-white px-4 py-2.5 text-center text-sm font-bold text-red-600 shadow-sm transition-all duration-200 hover:bg-red-50 sm:w-auto sm:px-5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                Upload Profile Picture
                            </label>

                            @if ($new_image)
                                <p class="mt-3 text-sm font-medium text-gray-600">New photo selected.</p>
                            @endif

                            @error('new_image') <span class="text-red-500 text-sm mt-3 font-medium bg-red-50 px-3 py-1 rounded-full">{{ $message }}</span> @enderror
                            
                            <div wire:loading wire:target="new_image" class="mt-4 text-red-600 font-medium animate-pulse text-sm">
                                Uploading preview...
                            </div>
                            
                            <!-- Static Info Blocks -->
                            <div class="mt-8 w-full space-y-4 rounded-2xl border border-gray-100 bg-gray-50 p-4 shadow-inner sm:mt-10 sm:p-6">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Learner Reference Number</p>
                                    <p class="text-lg font-semibold text-gray-800">{{ $student->lrn ?? 'N/A' }}</p>
                                </div>
                                <div class="pt-4 border-t border-gray-200">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Academic Section</p>
                                    <p class="text-lg font-semibold text-red-600">{{ $section }}</p>
                                </div>
                                <div class="pt-4 border-t border-gray-200">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Grade Level</p>
                                    <p class="text-lg font-semibold text-red-600">{{ $gradeLevel }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Edit Form -->
                        <div class="min-w-0 space-y-6 lg:flex-1">
                            <div class="border-b border-gray-100 pb-4 mb-6">
                                <h3 class="flex items-center text-lg font-bold text-gray-800 sm:text-xl">
                                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit Personal Details
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">Update your identification and contact records.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                                <div class="col-span-1 md:col-span-2 space-y-1">
                                    <label class="block text-sm font-semibold text-gray-700">First Name</label>
                                    <input type="text" wire:model="firstname" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-md py-3 px-4 transition-colors duration-200 bg-gray-50 hover:bg-white focus:bg-white">
                                    @error('firstname') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-sm font-semibold text-gray-700">Middle Name</label>
                                    <input type="text" wire:model="middlename" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-md py-3 px-4 transition-colors duration-200 bg-gray-50 hover:bg-white focus:bg-white">
                                    @error('middlename') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-sm font-semibold text-gray-700">Last Name</label>
                                    <input type="text" wire:model="lastname" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-md py-3 px-4 transition-colors duration-200 bg-gray-50 hover:bg-white focus:bg-white">
                                    @error('lastname') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-sm font-semibold text-gray-700">Contact Number</label>
                                    <input type="tel" wire:model="contact_number" placeholder="+639171234567"
                                        maxlength="13" inputmode="tel" pattern="\+63[0-9]{10}"
                                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-md py-3 px-4 transition-colors duration-200 bg-gray-50 hover:bg-white focus:bg-white">
                                    @error('contact_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-sm font-semibold text-gray-700">Parent Name</label>
                                    <input type="text" wire:model="parent_name" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-md py-3 px-4 transition-colors duration-200 bg-gray-50 hover:bg-white focus:bg-white">
                                    @error('parent_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-sm font-semibold text-gray-700">Parent Contact</label>
                                    <input type="tel" wire:model="parent_contact" placeholder="+639171234567"
                                        maxlength="13" inputmode="tel" pattern="\+63[0-9]{10}"
                                        class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-md py-3 px-4 transition-colors duration-200 bg-gray-50 hover:bg-white focus:bg-white">
                                    @error('parent_contact') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="space-y-1">
                                    <label class="block text-sm font-semibold text-gray-700">Birthdate</label>
                                    <input type="date" wire:model="birthdate" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-md py-3 px-4 transition-colors duration-200 bg-gray-50 hover:bg-white focus:bg-white">
                                    @error('birthdate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-span-1 md:col-span-2 space-y-1">
                                    <label class="block text-sm font-semibold text-gray-700">Address</label>
                                    <input type="text" wire:model="address" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-md py-3 px-4 transition-colors duration-200 bg-gray-50 hover:bg-white focus:bg-white">
                                    <p class="text-xs text-gray-400 mt-1 pl-1">Format: Street Address, Barangay, Region, Province, City/Municipality</p>
                                    @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col-reverse sm:flex-row sm:items-center justify-end sm:space-x-4">
                                <button type="button" wire:click="cancelEdit" class="mt-4 sm:mt-0 w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-semibold rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                    Cancel
                                </button>
                                <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl shadow-md text-white bg-red-600 hover:bg-red-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200" wire:loading.attr="disabled">
                                    <svg wire:loading.remove wire:target="save" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <svg wire:loading wire:target="save" class="animate-spin w-4 h-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="lg:flex lg:gap-12">
                    <!-- Left Side: Profile Picture View -->
                    <div class="relative mb-14 flex flex-col items-center lg:mb-0 lg:w-1/3">
                        <div class="mb-8 h-36 w-36 overflow-hidden rounded-full border-4 border-white shadow-2xl ring-4 ring-red-50 transition-transform duration-300 hover:scale-105 sm:h-48 sm:w-48">
                            @if ($student->image_path)
                                <img src="{{ asset('storage/' . $student->image_path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                            @endif
                        </div>
                        
                        <button wire:click="edit" class="absolute bottom-0 z-10 flex items-center rounded-full border border-red-100 bg-white px-6 py-2.5 text-sm font-bold text-red-600 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:bg-red-50 hover:shadow-xl lg:-bottom-4">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Profile
                        </button>
                    </div>

                    <!-- Right Side: Details View -->
                    <div class="min-w-0 lg:flex-1">
                        <div class="mb-8 border-b border-gray-100 pb-5">
                            <h3 class="break-words text-2xl font-bold tracking-tight text-gray-800 sm:text-3xl">{{ $student->firstname }} {{ $student->middlename }} {{ $student->lastname }}</h3>
                            <div class="mt-3 flex flex-wrap items-center gap-2 text-sm font-medium text-gray-500">
                                <span class="bg-red-50 text-red-700 px-3 py-1 rounded-full border border-red-100 shadow-sm tracking-wide">{{ $section }}</span>
                                <span class="text-gray-300">&bull;</span>
                                <span class="bg-red-50 text-red-700 px-3 py-1 rounded-full border border-red-100 shadow-sm tracking-wide">{{ $gradeLevel }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-8">
                            <div class="group">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-300 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                    Learner Reference Number
                                </p>
                                <p class="break-words text-lg font-semibold text-gray-800 sm:text-xl">{{ $student->lrn ?? 'N/A' }}</p>
                            </div>
                            
                            <div class="group">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-300 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    Contact Number
                                </p>
                                <p class="break-words text-lg font-semibold text-gray-800 sm:text-xl">{{ $student->contact_number ?: 'Not provided' }}</p>
                            </div>

                            <div class="group">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-300 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-2.13a4 4 0 10-8 0 4 4 0 008 0zm8-2a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Parent Name
                                </p>
                                <p class="break-words text-lg font-semibold text-gray-800 sm:text-xl">{{ $student->parent_name ?: 'Not provided' }}</p>
                            </div>

                            <div class="group">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-300 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    Parent Contact
                                </p>
                                <p class="break-words text-lg font-semibold text-gray-800 sm:text-xl">{{ $student->parent_contact ?: 'Not provided' }}</p>
                            </div>

                            <div class="group">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-300 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Birthdate
                                </p>
                                <p class="text-lg font-semibold text-gray-800 sm:text-xl">{{ date('F j, Y', strtotime($student->birthdate)) }}</p>
                            </div>

                            <div class="group sm:col-span-2 mt-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-300 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    Home Address
                                </p>
                                <p class="max-w-lg break-words text-base font-semibold leading-relaxed text-gray-800 sm:text-lg">{{ $student->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
