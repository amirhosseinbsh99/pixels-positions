<x-layout>
    <x-page-heading>Applicants for {{ $job->title }}</x-page-heading>

    @if($applications->isEmpty())
        <p class="text-gray-600">No one has applied to this job yet.</p>
    @else
        <div class="space-y-4">
            @foreach($applications as $application)
                <div class="border border-gray-300 p-4 rounded-lg">
                    <p class="font-semibold text-lg">{{ $application->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $application->user->email }}</p>

                    @if($application->cover_letter)
                        <p class="mt-2 italic text-gray-700">“{{ $application->cover_letter }}”</p>
                    @endif
                    
                    <p class="text-xs text-gray-400 mt-1">Applied at: {{ $application->created_at->format('Y-m-d H:i') }}</p>
                </div>
            @endforeach
        </div>
    @endif
</x-layout>
