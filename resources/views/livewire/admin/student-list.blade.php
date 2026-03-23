<div>
    <div class="bg-white rounded-xl p-5">
        {{-- <div class="mb-4">
            <x-native-select wire:model.live="selected_academic_year_id" label="Academic Year">
                <option value="">All Academic Years</option>
                @foreach ($academic_years as $year)
                    <option value="{{ $year->id }}">{{ $year->name }} {{ $year->is_active ? '(Active)' : '' }}</option>
                @endforeach
            </x-native-select>
        </div> --}}
        {{ $this->table }}
    </div>
</div>
