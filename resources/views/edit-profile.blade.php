<x-layout>

@section('content')
<div class="bg-white/5 p-8 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-6">Edit Profile</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-semibold mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
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
            <label for="avatar" class="block text-sm font-semibold mb-2">Profile Picture</label>
            <input type="file" name="avatar" id="avatar"
                   class="w-full px-4 py-2 text-white bg-black border border-white/10 rounded-lg focus:outline-none">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg font-semibold transition duration-200">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
</x-layout>
