<div class="flex flex-col justify-center items-center w-full mb-5">
    <div class="">
        <img src="{{ Storage::url($getRecord()->image_path) }}" alt=""
            class="h-32 object-cover  w-32 rounded-full border-gray-400 border-4 ">

    </div>
    <div class="mt-2 text-center">
        <h1 class="font-bold text-lg uppercase">
            {{ $getRecord()->lastname . ', ' . $getRecord()->firstname . ' ' . ($getRecord()->middlename == null ? '' : $getRecord()->middlename[0] . '.') }}
        </h1>
        <h1 class="font-semibold text-main ">
            {{ $getRecord()->gradeLevel->name . ' - ' . $getRecord()->section->name }}
        </h1>
    </div>

</div>
