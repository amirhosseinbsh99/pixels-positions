{{-- resources/views/jobs/my-applications.blade.php --}}
<x-layout>
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        {{-- Page heading --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white">
                My Applications
                <span class="text-sm font-normal text-gray-400">({{ $applications->count() }})</span>
            </h2>
        </div>

        {{-- Applications list --}}
        @if ($applications->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($applications as $application)
                    <div class="bg-gray-700 p-5 rounded-xl shadow-md hover:shadow-xl transition duration-300 relative border border-gray-600">
                        {{-- Job Title --}}
                        <h3 class="text-xl font-semibold text-white mb-1">
                            {{ $application->job->title }}
                        </h3>

                        {{-- Company --}}
                        <p class="text-sm text-blue-300 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v4a1 1 0 001 1h1v7h14v-7h1a1 1 0 001-1V7a1 1 0 00-1-1h-2l-2-2H8L6 6H4a1 1 0 00-1 1z" />
                            </svg>
                            {{ $application->job->employer->name ?? 'Unknown Company' }}
                        </p>

                        {{-- Applied Date --}}
                        <p class="text-sm text-gray-400 mb-2">
                            Applied on: <span class="text-white">{{ $application->created_at->format('Y-m-d') }}</span>
                        </p>

                        {{-- Status --}}
                        @php
                            $color = match($application->status) {
                                'accepted' => 'bg-green-500/20 text-green-300',
                                'denied' => 'bg-red-500/20 text-red-300',
                                default => 'bg-yellow-500/20 text-yellow-300',
                            };
                        @endphp
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                            {{ ucfirst($application->status) }}
                        </span>

                        {{-- Cover Letter --}}
                        @if($application->cover_letter)
                            <div class="mt-4 text-sm text-gray-200">
                                <p class="font-semibold mb-1">Cover Letter:</p>
                                <blockquote class="italic border-l-4 border-blue-400 pl-3 text-gray-300">
                                    {{ Str::limit($application->cover_letter, 150) }}
                                </blockquote>
                            </div>
                        @endif

                        {{-- Cancel Button --}}
                        {{-- Cancel Button --}}
                        @if ($application->status === 'pending')
                            <form action="{{ route('applications.cancel', $application) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this application?');" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-red-300 bg-red-500/10 border border-red-500/30 rounded-md hover:bg-red-500/20 hover:text-red-200 transition duration-200 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Cancel Application
                                </button>
                            </form>
                        @endif

                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 text-center mt-8 text-lg">You haven't applied to any jobs yet.</p>
        @endif
    </div>
</x-layout>
