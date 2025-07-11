{{-- resources/views/jobs/my-jobs.blade.php --}}
<x-layout>
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        {{-- page heading --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold">
                My jobs
                <span class="text-sm font-normal text-gray-400">({{ $featuredjobs->count() + $jobs->count() }})</span>
            </h2>
            <a href="{{ route('jobs.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-200">
                + Post a Job
            </a>
        </div>
        <h3 class="text-lg font-semibold text-blue-400 mb-4">Featured jobs</h3>
        {{-- FEATURED JOBS ---------------------------------------------------- --}}
        @if ($featuredjobs->isNotEmpty())
            

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                @foreach ($featuredjobs as $job)
                    @include('components.Myjob-card', ['job' => $job, 'highlight' => true])
                @endforeach
            </div>
        @endif
        <h3 class="text-lg font-semibold text-gray-200 mb-4">Regular jobs</h3>
        {{-- REGULAR JOBS ----------------------------------------------------- --}}
        @if ($jobs->isNotEmpty())
            

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($jobs as $job)
                    @include('components.Myjob-card', ['job' => $job])
                @endforeach
            </div>
        @else
            <p class="text-gray-400">You do not have any jobs</p>
        @endif
    </div>
</x-layout>
