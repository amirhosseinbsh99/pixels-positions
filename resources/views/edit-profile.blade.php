<style>
    .ts-control input {
    color: white;
    font-size: 1rem;
    padding: 0.5rem 0;
    background: transparent;
    min-width: 100%;
    }
    .tom-select .ts-dropdown .option {
        pointer-events: none; /* disable mouse interactions */
    }
    kbd {
    background-color: #44475a;
    border-radius: 4px;
    padding: 2px 6px;
    font-size: 0.75rem;
    font-weight: 600;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    user-select: none;
}

select[multiple] {
    min-height: 4.5rem;
}

/* Optional: soften the border and add subtle shadow for better input feel */
select {
    box-shadow: 0 0 8px rgb(128 90 213 / 0.15);
}
</style>
<x-layout>
    <div class="bg-gradient-to-b from-white/10 to-white/5 backdrop-blur-lg p-10 rounded-3xl shadow-2xl max-w-3xl mx-auto mt-10 border border-white/10">
        <h2 class="text-3xl font-extrabold text-white mb-8">Edit Profile</h2>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-600/80 text-white rounded-xl border border-red-400">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-600/80 text-white rounded-xl border border-green-400">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-white mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                       class="w-full px-4 py-3 rounded-xl bg-black/70 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-purple-500 focus:outline-none transition">
            </div>

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-white mb-1">Current Password</label>
                <input type="password" name="current_password" id="current_password"
                       class="w-full px-4 py-3 rounded-xl bg-black/70 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-purple-500 focus:outline-none transition"
                       placeholder="Only if changing password">
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-white mb-1">New Password</label>
                <input type="password" name="password" id="password"
                       class="w-full px-4 py-3 rounded-xl bg-black/70 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-purple-500 focus:outline-none transition">
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-white mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="w-full px-4 py-3 rounded-xl bg-black/70 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-purple-500 focus:outline-none transition">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-white mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                       class="w-full px-4 py-3 rounded-xl bg-black/70 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-purple-500 focus:outline-none transition">
            </div>

            <!-- Bio -->
            <div>
                <label for="bio" class="block text-sm font-medium text-white mb-1">Bio</label>
                <textarea name="bio" id="bio" rows="4"
                          class="w-full px-4 py-3 rounded-xl bg-black/70 border border-white/10 text-white placeholder-white/50 focus:ring-2 focus:ring-purple-500 focus:outline-none transition">{{ old('bio', auth()->user()->bio) }}</textarea>
            </div>

            <!-- Profile Picture -->
            <div>
                <label for="logo" class="block text-sm font-medium text-white mb-2">Profile Picture</label>

                @if(auth()->user()->logo)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . auth()->user()->logo) }}"
                            alt="Current Profile Picture"
                            class="w-24 h-24 rounded-full object-cover border-2 border-purple-500 shadow-md">
                    </div>
                @endif

                <input type="file" name="logo" id="logo"
                    class="w-full px-4 py-2 text-white file:bg-purple-600 file:text-white file:rounded-md file:border-0 file:px-4 file:py-2 file:cursor-pointer bg-black/70 border border-white/10 rounded-xl focus:outline-none">
            </div>

            <!-- User Type -->
            <div>
                <label for="user_type" class="block text-sm font-medium text-white mb-1">Account Type</label>
                <select name="user_type" id="user_type"
                        class="w-full px-4 py-3 rounded-xl bg-black/70 border border-white/10 text-white focus:ring-2 focus:ring-purple-500 focus:outline-none transition">
                    <option value="jobseeker" {{ old('user_type', auth()->user()->user_type) === 'jobseeker' ? 'selected' : '' }}>Job Seeker</option>
                    <option value="employer" {{ old('user_type', auth()->user()->user_type) === 'employer' ? 'selected' : '' }}>Employer</option>
                </select>
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-white mb-1">Category</label>
                <select name="category_id" id="category_id"
                        class="w-full px-4 py-3 rounded-xl bg-black/70 border border-white/10 text-white focus:ring-2 focus:ring-purple-500 focus:outline-none transition">
                    <option value="">-- Select a category --</option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', auth()->user()->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        <!-- Tags (inside form, before submit button) -->
        @php
            $userTagNames = auth()->user()->tags->pluck('name')->toArray();
        @endphp

    <!-- Skills -->
    <div>
        <label for="tags" class="block text-sm font-medium text-white mb-1 relative cursor-help" 
            title="Hold Ctrl (Cmd on Mac) to select multiple skills or use the search to add/remove tags">
            Skills
            <span class="ml-1 text-xs text-white/50">🛈</span>
        </label>
        <p class="text-xs text-white/70 mb-2 italic select-none">
            Tip: Hold <kbd class="px-1 py-0.5 bg-gray-700 rounded text-white text-xs">Ctrl</kbd> (or 
            <kbd class="px-1 py-0.5 bg-gray-700 rounded text-white text-xs">Cmd</kbd> on Mac) to select multiple skills.
        </p>
        <select id="tags" name="tags[]" multiple
                class="w-full px-4 py-3 rounded-xl bg-black/70 border border-white/20 text-white
                    focus:ring-2 focus:ring-purple-500 focus:outline-none transition shadow-sm">
            @foreach($userTagNames as $tag)
                <option value="{{ $tag }}" selected>{{ $tag }}</option>
            @endforeach
        </select>
    </div>


            <!-- Submit Button -->
            <div class="flex justify-end pt-4">
                <button type="submit"
                        class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-xl shadow-md transition duration-200">
                    Save Changes
                </button>
            </div>
            
        </form>
        



    </div>
<script>
    const allTags = @json(\App\Models\Tag::pluck('name'));

    new TomSelect('#tags', {
        create: false,
        maxItems: 10,
        persist: false,
        plugins: ['remove_button'],
        placeholder: 'Type to search skills...',
        load: function(query, callback) {
            if (!query.length) return callback(); // Don't load anything until user types
            const filtered = allTags
                .filter(tag => tag.toLowerCase().includes(query.toLowerCase()))
                .map(name => ({ value: name, text: name }));
            callback(filtered);
        }
    });


</script>
</x-layout>
