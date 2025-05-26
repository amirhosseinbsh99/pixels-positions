<x-layout>

<div class="bg-white/5 p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6">Edit Profile</h2>
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-600 text-white rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-600 text-white rounded">
            {{ session('success') }}
        </div>
    @endif


    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-semibold mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                   class="w-full px-4 py-2 bg-black border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-white">
        </div>
        <div>
            <label for="current_password" class="block text-sm font-semibold mb-2">Current Password (if you want to change your password)</label>
            <input type="password" name="current_password" id="current_password"
                class="w-full px-4 py-2 bg-black border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-white">
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold mb-2">New Password</label>
            <input type="password" name="password" id="password"
                class="w-full px-4 py-2 bg-black border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-white">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold mb-2">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="w-full px-4 py-2 bg-black border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-white">
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                   class="w-full px-4 py-2 bg-black border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-white">
        </div>

        <div>
            <label for="bio" class="block text-sm font-semibold mb-2">Bio</label>
            <textarea name="bio" id="bio" rows="4"
                      class="w-full px-4 py-2 bg-black border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-white">{{ old('bio', auth()->user()->bio) }}</textarea>
        </div>

        <div>
            <label for="logo" class="block text-sm font-semibold mb-2">Profile Picture</label>
            <input type="file" name="logo" id="logo"
                   class="w-full px-4 py-2 text-white bg-black border border-white/10 rounded-lg focus:outline-none">
        </div>
        <div>
            <label for="user_type" class="block text-sm font-semibold mb-2">Account Type</label>
            <select name="user_type" id="user_type"
                    class="w-full px-4 py-2 bg-black border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-white">
                <option value="jobseeker" {{ old('user_type', auth()->user()->user_type) === 'jobseeker' ? 'selected' : '' }}>Job Seeker</option>
                <option value="employer" {{ old('user_type', auth()->user()->user_type) === 'employer' ? 'selected' : '' }}>Employer</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg font-semibold transition duration-200">
                Save Changes
            </button>
        </div>
    </form>
</div>
</x-layout>