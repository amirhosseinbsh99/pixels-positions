<x-layout>
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-6">Welcome to Your Dashboard, {{ auth()->user()->name }}</h2>
        @if(auth()->user())
        
        <img src="{{ asset(auth()->user()->logo) }}" alt="Your Logo" class="rounded-xl w-32 h-32 object-cover mb-5">
        @else
            <img src="{{ asset('images/default-employer.png') }}" alt="Default Logo" class="rounded-xl w-32 h-32 object-cover opacity-50">
        @endif
        <h3 class="text-xl font-bold mb-6 mt-1
            {{ auth()->user()->user_type == 'employer' ? 'text-blue-500' : (auth()->user()->user_type == 'jobseeker' ? 'text-green-500' : '') }}">
            {{ ucfirst(auth()->user()->user_type) }}
        </h3>

        <h3 class="text-x font-bold mb-6 mt-1">{{auth()->user()->bio}}</h3> 
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- User Information Section -->
            <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg text-gray-200">Your Profile</h3>
                <p class="mt-2 text-gray-400">Here’s a quick overview of your profile.</p>
                
                <!-- Display User's Name and Email -->
                <div class="mt-4">
                    <p class="text-gray-300">Name: {{ auth()->user()->name }}</p>
                    <p class="text-gray-300">Email: {{ auth()->user()->email }}</p>
                </div>

                <div class="mt-6">
                    <a href="dashboard/edit" class="text-blue-400 hover:text-blue-300 font-semibold">Edit Profile</a>
                </div>
            </div>

            <!-- Job Recommendations Section -->
            @php
                $userTags = auth()->user()->tags->pluck('name')->toArray();
            @endphp

            <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                
                <h3 class="font-semibold text-lg text-gray-200">Job Recommendations</h3>
                <p class="mt-2 text-gray-400">Based on your skills and preferences.</p>
                <div class="mt-6">
                    @if(auth()->user()->category_id)
                        <a href="{{ route('search', ['category_id' => auth()->user()->category_id]) }}"
                        class="text-blue-400 hover:text-blue-300 font-semibold">
                        Browse Recommended Jobs
                        </a>
                    @else
                        <p class="text-red-400 mt-2">You need to select a category in your profile to see recommended jobs.</p>
                    @endif

                </div>
            </div>
            
            
            @if (auth()->user()->user_type == 'employer')
                
            
            <!-- Application Status Section -->
            <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg text-gray-200">Your Jobs</h3>
                <p class="mt-2 text-gray-400">List of jobs you created</p>

                <div class="mt-6">
                    <a href="{{ route('jobs.myjobs') }}" class="text-blue-400 hover:text-blue-300 font-semibold">View All Your Jobs</a>
                </div>
            </div>
            @elseif (auth()->user()->user_type == 'jobseeker')
            <!-- Application Status Section -->
            <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg text-gray-200">Your Applications</h3>
                <p class="mt-2 text-gray-400">Track the status of your job applications.</p>

                <div class="mt-6">
                    <a href="{{ route('job.myapplies') }}" class="text-blue-400 hover:text-blue-300 font-semibold">View All Applications</a>
                </div>
            </div>
            @endif
            
        </div>
    </div>
</x-layout>