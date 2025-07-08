<x-layout>
    
    <section class="container mx-auto p-8 bg-gradient-to-r from-blue-900 via-blue-700 to-blue-600 rounded-lg shadow-lg text-white">
        
        <h1 class="text-4xl font-bold text-center mb-6 hover:text-blue-400 transition-colors duration-300">{{ $job->title }}</h1>
        
        <div>
            <x-employer-logo class=" rounded-4xl" :width="150" :employer="$job->employer" /> 
            <h1 class="font-bold text-2xl">Employer: {{$job->employer->name}}</h1>    
        </div>  

        <div class="flex justify-center mb-6">
            <p class="text-xl font-semibold">{{ $job->company }}</p>
        </div>

        <div class="flex justify-center mb-6">
            <p class="text-gray-300 italic font-bold">{{ \Illuminate\Support\Str::ucfirst($job->location) }}</p>
        </div>

        <!-- Job Description Section -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-white mb-3">Job Description:</h2>
            <p class="text-lg text-gray-300 leading-relaxed">{!! nl2br(e($job->description)) !!}</p>
        </div>

        <!-- Salary Section -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-white mb-3">Salary:</h3>
            <p class="text-lg text-gray-300">${{ $job->salary }}</p>
        </div>

        <!-- Other Job Details Section -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-white mb-3">Job Tags:</h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($job->tags as $tag)
                    <span class="bg-blue-500 text-white py-1 px-3 rounded-full text-sm">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>

        <div class="justify-center">
        <x-forms.form class="justify-center items-center" method="POST" action="/jobs/{{ $job->id }}/apply">
            @csrf
            <x-forms.textarea label="Cover Letter (optional)" name="cover_letter" placeholder="Write something about why you are a good fit..."/>
            <div class="flex justify-center">
            <x-forms.button type="submit" class="flex justify-center mt-4">Apply to This Job</x-forms.button>
            </div>
        </x-forms.form>
        </div>
        <!-- Back Button Section -->
        <div class="mt-6 flex justify-center">
            <a href="{{ url()->previous() }}" class="text-white bg-blue-600 hover:bg-blue-500 font-semibold py-3 px-6 rounded-lg border-2 border-blue-600 hover:border-blue-500 flex items-center space-x-2 transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 12H7m5 5l-5-5 5-5"></path>
                </svg>
                <span>Back to Job Listings</span>
            </a>
        </div>

    </section>
</x-layout>
