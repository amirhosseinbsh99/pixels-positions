@props(['employer'])

<img 
    src="{{ $employer->logo ? asset($employer->logo) : asset('images/default-user.png') }}" 
    alt="Employer Logo" 
    class="rounded-xl" 
    width="90">
