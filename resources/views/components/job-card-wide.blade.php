@props(['job'])
<x-panel class="flex gap-x-9 mb-7">
        <div>
        <x-employer-logo :employer="$job->employer"/>
    <div class="flex-1 flex flex-col">
        <a href="" class="self-start text-sm text-gray-500">{{$job->employer->name}}</a>
        <div>
            <h3 class="font-bold text-xl mt-3 group-hover:text-blue-800 transition-colors duration-300">
                <a href="{{$job->url}}" target="_blank"></a>
                {{$job->title}}

            </h3>
            <p class="text-sm text-gray-400 mt-10">${{$job->salary}}</p>
        </div>
    </div>
        <div>
            @foreach ($job->tags as $tag )
                <x-tag  :$tag ></x-tag>
                
            @endforeach
        </div>


    </div>
</x-panel>