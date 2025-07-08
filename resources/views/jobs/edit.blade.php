<x-layout>
    <div class="max-w-3xl mx-auto bg-gray-800 p-8 rounded-xl shadow-md mt-10 text-white">
        <h2 class="text-2xl font-bold mb-6">Edit Job Posting</h2>

        <form method="POST" action="{{ route('jobs.update', $job->id) }}">
            @csrf
            @method('PUT')

            <!-- Job Title -->
            <div class="mb-4">
                <label for="title" class="block mb-1 font-semibold">Job Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $job->title) }}"
                       class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('title')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Salary -->
            <div class="mb-4">
                <label for="salary" class="block mb-1 font-semibold">Salary</label>
                <input type="text" id="salary" name="salary" value="{{ old('salary', $job->salary) }}"
                       class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('salary')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label for="category_id" class="block mb-1 font-semibold">Category</label>
                <select id="category_id" name="category_id"
                        class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div class="mb-4">
                <label for="location" class="block mb-1 font-semibold">Location</label>
                <input type="text" id="location" name="location" value="{{ old('location', $job->location) }}"
                       class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('location')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Schedule -->
            <div class="mb-4">
                <label for="schedule" class="block mb-1 font-semibold">Schedule</label>
                <select name="schedule" id="schedule"
                        class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Full Time" {{ old('schedule', $job->schedule) == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                    <option value="Part Time" {{ old('schedule', $job->schedule) == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                </select>
                @error('schedule')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL -->
            <div class="mb-4">
                <label for="url" class="block mb-1 font-semibold">Application URL (optional)</label>
                <input type="url" id="url" name="url" value="{{ old('url', $job->url) }}"
                       class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('url')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tags -->
            <div class="mb-4">
                <label for="tags" class="block mb-1 font-semibold">Tags (comma separated)</label>
                <input type="text" id="tags" name="tags"
                       value="{{ old('tags', $job->tags->pluck('name')->implode(',')) }}"
                       class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('tags')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Featured -->
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="featured" class="form-checkbox text-blue-500"
                        {{ old('featured', $job->featured) ? 'checked' : '' }}>
                    <span class="ml-2">Mark as Featured</span>
                </label>
            </div>

            <!-- Submit -->
            <div class="flex justify-between">
                <a href="{{ route('jobs.myjobs') }}"
                   class="px-4 py-2 bg-gray-600 hover:bg-gray-700 rounded text-white font-semibold">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded font-semibold text-white transition">
                    Update Job
                </button>
            </div>
        </form>
    </div>
</x-layout>
