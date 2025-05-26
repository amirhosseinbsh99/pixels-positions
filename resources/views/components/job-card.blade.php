@props(['job'])

<x-panel class="flex flex-col text-center p-4">

    <div class="flex items-center justify-center space-x-4 py-8">
        <x-employer-logo :employer="$job->employer" :width="50" />

        <h3 class="font-bold group-hover:text-blue-600 transition-colors duration-300">
            <a href="{{ route('jobs.job-detail', $job->id) }}" class="hover:text-blue-600">
                {{ $job->title }}
            </a>
        </h3>
    </div>

    <p class="text-sm mt-4 mb-5 group-hover:text-blue-600 transition-colors duration-300">${{ $job->salary }}</p>

    <div class="flex justify-between items-center mt-auto">
        <div class="flex flex-wrap gap-2">
            @foreach ($job->tags as $tag)
                <x-tag :tag="$tag" size="small" />
            @endforeach
        </div>
    </div>
    
</x-panel>
