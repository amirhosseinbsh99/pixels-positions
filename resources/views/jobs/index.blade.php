<x-layout>
    <div class="space-y-10">
        <section class="text-center pt-6">
            <h1 class="font-bold text-4xl ">Let's find you a job</h1>
        <x-forms.form action="/search" class="mt-6">
            <x-forms.input :label="false" name="q" placeholder="Web Developer"/>
        </x-forms.form>
        </section>
        <section class="pt-10">
            <x-section-heading>featured jobs</x-section-heading>
    
            <div class="grid lg:grid-cols-3 gap-8 mt-6">
                @foreach ($featuredjobs as $job)
                    <x-job-card :$job >
                        
                    </x-job-card>
                @endforeach
            </div>
        </section>
    
        
        <section>
            <x-section-heading>Recent jobs</x-section-heading>
            <div class="mt-6 space-x-6 ">
                @foreach ($jobs as $job)
                    <x-job-card-wide :$job />
                    
                @endforeach
            </div>

        </section>
        
    </div>
</x-layout>