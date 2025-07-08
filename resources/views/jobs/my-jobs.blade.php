{{-- resources/views/jobs/my-jobs.blade.php --}}
<x-layout>
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        {{-- page heading --}}
        <h2 class="text-xl font-bold mb-6">
            My jobs
            <span class="text-sm font-normal text-gray-400">({{ $featuredjobs->count() + $jobs->count() }})</span>
        </h2>

        {{-- FEATURED JOBS ---------------------------------------------------- --}}
        @if ($featuredjobs->isNotEmpty())
            <h3 class="text-lg font-semibold text-blue-400 mb-4">Featured jobs</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                @foreach ($featuredjobs as $job)
                    @include('components.Myjob-card', ['job' => $job, 'highlight' => true])
                    
                @endforeach
                
            </div>
            
        @endif

        {{-- REGULAR JOBS ----------------------------------------------------- --}}
        @if ($jobs->isNotEmpty())
            <h3 class="text-lg font-semibold text-gray-200 mb-4">jobs</h3>

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
