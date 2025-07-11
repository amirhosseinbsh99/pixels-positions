@props(['employer','width' => 90])

<img 
    src="{{ $employer && $employer->logo ? asset($employer->logo) : asset('images/default-user.png') }}" 
    alt="Employer Logo" 
    class="rounded-xl" 
    width="{{ $width ?? 90 }}"
>
