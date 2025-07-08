@props(['label', 'name', 'placeholder' => '', 'rows' => 4])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-gray-700 font-semibold mb-2">{{ $label }}</label>
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500']) }}
    >{{ old($name) }}</textarea>

    @error($name)
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
