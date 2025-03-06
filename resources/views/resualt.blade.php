<x-layout>
    <x-page-heading>Resualts</x-page-heading>
    <div class="space-x-6 ">
        @foreach ($jobs as $job)
            <x-job-card-wide :$job />
            
        @endforeach
    </div>
</x-layout>