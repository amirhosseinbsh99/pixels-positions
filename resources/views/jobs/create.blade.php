<x-layout>
    <x-page-heading>New Job</x-page-heading>

    <x-forms.form method="POST" action="/jobs">
        @csrf

        <!-- Job Title Input -->
        <x-forms.input label="Title" name="title" placeholder="CEO"/>

        <!-- Salary Input -->
        <x-forms.input label="Salary" name="salary" placeholder="90,000$ USD"/>

        <!-- Location Input -->
        <x-forms.input label="Location" name="location" placeholder="New York"/>

        <!-- Schedule Selection -->
        <x-forms.select label="Schedule" name="schedule">
            <option class="bg-black text-white rounded-lg p-2" value="Part Time">Part Time</option>
            <option class="bg-black text-white rounded-lg p-2"  value="Full Time">Full Time</option>
        </x-forms.select>

        <!-- Job URL Input -->
        <x-forms.input label="URL" name="url" placeholder="http://acme.com/jobs/ceo-wanted"/>

        <!-- Featured Checkbox -->
        <x-forms.checkbox label="Featured (Costs Extra)" name="featured"/>

        <x-forms.divider/>

        <!-- Category Selection -->
        <x-forms.select  label="Category" name="category_id">
            @foreach (\App\Models\Category::all() as $category)
                <option class="bg-black text-white rounded-lg p-2"value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </x-forms.select>

        <!-- Tags Input -->
        <x-forms.input label="Tags (comma separated)" name="tags" placeholder="video, education"/>

        <!-- Submit Button -->
        <x-forms.button type="submit">Publish</x-forms.button>
    </x-forms.form>
</x-layout>
