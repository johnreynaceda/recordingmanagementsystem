<div>
    <div class="bg-white p-10 rounded-xl">
        <div class="flex justify-between items-center">
            <div></div>
            <div></div>
        </div>
        <div class="mt-5">
            <h1 class="font-bold text-xl text-main">STUDENT'S INFORMATION</h1>
            <div class="mt-10 grid grid-cols-4 gap-5">
                <div class="col-span-1 flex justify-center">
                    <img src="{{ Storage::url($students->image_path ?? '') }}" alt=""
                        class="rounded-full object-cover h-32 w-32 border-4 border-main/70">
                </div>
                <div class="col-span-3 w-full  gap-5">
                    <div class="grid grid-cols-4 gap-5 ">
                        <div>
                            <h1 class="text-sm">Firstname</h1>
                            <h1 class="font-semibold">{{$student->firstname}}</h1>
                        </div>
                        <div>
                            <h1 class="text-sm">Middle Name</h1>
                            <h1 class="font-semibold">{{$student->middlename}}</h1>
                        </div>
                        <div>
                            <h1 class="text-sm">Lastname</h1>
                            <h1 class="font-semibold">{{$student->lastname}}</h1>
                        </div>
                        <div>
                            <h1 class="text-sm">Birthday</h1>
                            <h1 class="font-semibold">{{$student->birthdate}}</h1>
                        </div>
                        <div>
                            <h1 class="text-sm">Address</h1>
                            <h1 class="font-semibold">{{$student->address}}</h1>
                        </div>
                        {{-- <div>
                            <h1 class="text-sm">Firstname</h1>
                            <h1 class="font-semibold">JUAN DELA CRUZ</h1>
                        </div>
                        <div>
                            <h1 class="text-sm">Firstname</h1>
                            <h1 class="font-semibold">JUAN DELA CRUZ</h1>
                        </div> --}}
                    </div>
                </div>
            </div>

        </div>
        <div class="mt-5 border-t pt-5">
            <section>
                <div class="relative ">
                    <section>
                        <div class="">
                            <div x-data="{ tab: 'tab1' }">
                                <ul class="flex gap-5 text-sm text-base-500 border-b">
                                    @foreach ($student_records as $item)
                                        <li class="-mb-px">
                                            <a @click.prevent="tab = '{{ $item->gradeLevel->name }}'"
                                                class="inline-block py-2 font-medium cursor-pointer"
                                                :class="{ 'bg-white text-accent-500 border-b-2 border-main': tab === '{{ $item->gradeLevel->name }}' }">
                                                {{ $item->gradeLevel->name. ' - '. $item->section->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="py-4 pt-4 text-left bg-white content">
                                    @foreach ($student_records as $item)
                                        <div x-show="tab === '{{ $item->gradeLevel->name }}'" class="text-base-500">
                                            <main class="py-4">
                                                <p class="text-base-500 text-sm">{{ $item->gradeLevel->name }} content
                                                </p>
                                            </main>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </section>


        </div>
    </div>
</div>
