@props(['job'])

<x-panel class="flex flex-col text-center">
    <div class="self-start text-sm">{{ $job->employer->name }}</div>
    <div class="py-8">
        <h3 class="font-bold group-hover:text-blue-600 transition-colors duration-300">
            <!-- Wrap the title in the anchor tag for job detail link -->
            <a href="{{ route('jobs.job-detail', $job->id) }}" class="hover:text-blue-600">
                {{ $job->title }}
            </a>
        </h3>
        <p class="text-sm mt-4 group-hover:text-blue-600 transition-colors duration-300">{{ $job->salary }}</p>
    </div>

    <div class="flex justify-between items-center mt-auto">
        <div>
            @foreach ($job->tags as $tag)
                <x-tag :$tag size="small"></x-tag>
            @endforeach
        </div>
        <x-employer-logo :employer="$job->employer" :width="42" />
    </div>
</x-panel>
