<x-layout>
    <div class="bg-gray-900 p-8 rounded-2xl shadow-2xl max-w-6xl mx-auto">
        <h2 class="text-3xl font-extrabold text-white mb-10 border-b border-gray-700 pb-4">
            Applicants for: <span class="text-blue-400">{{ $job->title }}</span>
        </h2>

        @if ($applications->isNotEmpty())
            <div class="space-y-8">
                @foreach ($applications as $application)
                    <div class="bg-gray-800 p-6 rounded-xl shadow-lg transition transform hover:scale-[1.01] flex flex-col sm:flex-row sm:justify-between sm:items-center border border-gray-700">
                        <div class="space-y-2">
                            @if (!empty(optional($job->employer)->logo) && file_exists(storage_path('app/public/' . $job->employer->logo)))

                            <img src="{{ asset('storage/' .$job->employer->logo)}}" alt="Employer Image" class="mt-2 w-16 h-16 rounded-full">
                            @else
                                <img src="{{ asset( url('/images/default-user.png')) }}" alt="Default Employer Image" class="mt-2 w-16 h-16 rounded-full">
                            @endif
                            <h3 class="text-xl font-semibold text-white">{{ $application->user->name ?? 'Unknown' }}</h3>
                            <p class="text-gray-400 text-sm">{{ $application->user->email ?? 'No email' }}</p>
                            <p class="text-gray-500 text-xs">Applied on: {{ $application->created_at->format('Y-m-d') }}</p>

                            @if ($application->cover_letter)
                                <p class="text-gray-300 text-sm italic mt-2 max-w-xl">
                                    “{{ \Illuminate\Support\Str::limit($application->cover_letter, 200) }}”
                                </p>
                            @endif

                            <p class="text-sm mt-1">
                                <span class="text-gray-400">Status:</span> 
                                @php
                                    $color = match($application->status) {
                                        'accepted' => 'text-green-400',
                                        'denied' => 'text-red-400',
                                        default => 'text-yellow-400',
                                    };
                                @endphp
                                <span class="{{ $color }} font-semibold capitalize">{{ $application->status }}</span>
                            </p>
                        </div>

                        <div class="mt-6 sm:mt-0 flex flex-col gap-3 sm:flex-row items-start sm:items-center">
                            @if ($application->status === 'pending')
                                <form action="{{ route('applications.updateStatus', $application) }}" method="POST" class="flex space-x-3">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" name="status" value="accepted" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition shadow-md">
                                        Accept
                                    </button>

                                    <button type="submit" name="status" value="denied" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition shadow-md">
                                        Reject
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 text-center mt-10">No applicants have applied to this job yet.</p>
        @endif
    </div>
</x-layout>
