@props(['job'])

<x-panel class="flex flex-col text-center p-4  hover:border-blue-800 group transition-colors duration-300">

    <div class="flex items-center justify-center space-x-4 py-8">
        <x-employer-logo :employer="$job->employer" :width="50" />

        <h3 class="font-bold group-hover:text-blue-600 transition-colors duration-300">
            <a href="{{ route('jobs.job-detail', $job->id) }}" class="hover:text-blue-600">
                {{ $job->title }}
            </a>
        </h3>
    </div>

    <p class="text-sm mt-4 mb-5 group-hover:text-blue-600 transition-colors duration-300">${{ $job->salary }}</p>
        <div class="flex justify-center gap-3 mt-4">
        <a href="{{ route('job.myjob.applicants', $job->id) }}">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded transition duration-200 py-3 px-2">
                Applicants
            </button>
        </a>

        <a href="{{ route('jobs.edit', $job->id) }}">
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded transition duration-200 py-3 px-5">
                Edit
            </button>
        </a>

        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button class="bg-red-600 hover:bg-red-700 text-white font-semibold rounded transition duration-200 py-3 px-3">
                Delete
            </button>
        </form>
    </div>
    <div class="flex justify-between items-center mt-auto">
        <div class="flex flex-wrap gap-2">
            @foreach ($job->tags as $tag)
                <x-tag :tag="$tag" size="small" />
            @endforeach
        </div>
    </div>
    
</x-panel>



