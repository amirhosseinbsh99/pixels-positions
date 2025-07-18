<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pixel Postions</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

</head>

<body class="bg-black text-white pb-20">
    <div class="px-10">
        <nav class="flex justify-between items-center py-4 border-b border-white/10">
            <div>
                <a href="/">
                    <img src="{{ Vite::asset('resources/images/logo.svg')}}" alt="">
                </a>
                
            </div>

            @guest
            <div class="space-x-6 font-bold ">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('search') }}">Browse Jobs</a>
                <a href="{{ route('aboutus') }}">About Us</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>
            @endguest
            @auth
            <div class="ml-19 space-x-6 font-bold flex items-center">
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('search') }}">Browse Jobs</a>
    <a href="{{ route('aboutus') }}">About Us</a>
    <a href="{{ route('contact') }}">Contact</a>
    
    <!-- Categories button right next to Contact -->
    <div class="relative">
        <button id="categoriesButton" class="font-bold px-4 py-2 bg-white text-black rounded hover:bg-gray-200 transition flex items-center">
            Categories
            <svg id="categoriesIcon" class="w-4 h-4 ml-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div id="categoriesDropdown" 
    class="absolute hidden flex flex-col min-w-[220px] max-h-56 overflow-y-auto bg-gradient-to-b from-zinc-800 to-black border border-purple-600 rounded-xl mt-2 py-2 z-20 shadow-2xl scrollbar-thin scrollbar-thumb-purple-600 scrollbar-track-zinc-900">
    <!-- Optional search input for filtering categories -->
    <input type="text" id="categorySearch" placeholder="Search categories..." 
        class="mb-2 mx-3 px-2 py-1 rounded bg-zinc-900 text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600">
        
    @forelse($allCategories as $category)
    <a href="{{ route('search', ['category_id' => $category->id]) }}" 
        class="w-full px-5 py-2 text-sm text-white hover:bg-purple-700 hover:text-white transition-all duration-200 rounded-md">
        {{ $category->name }}
    </a>
    @empty
    <span class="px-5 py-2 text-sm text-gray-400">No categories found</span>
    @endforelse
</div>


    </div>
</div>
        
            <div class="space-x-6 font-bold flex">

                <!-- Dropdown for My Profile -->
                
                <div class="relative">
                    
                    <button class="flex items-center cursor-pointer" id="profileButton">
                        
                        <!-- Dropdown icon (Initially pointing right) -->
                        <div class="w-8 h-8 rounded-full overflow-hidden">
                            <img src="{{ auth()->user()->logo ? url(auth()->user()->logo) : asset('/images/default-user.png') }}" alt="User Avatar" class="w-full h-full object-cover">

                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 mr-2 w-4 h-4 transform transition-transform duration-200" id="dropdownIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            
                        </svg>
                        <!-- User Avatar Circle -->
                        
                        My Profile
                        
                    </button>
            
                    <!-- Dropdown menu (Hidden by default) -->
                    <div class="absolute hidden bg-black text-white border rounded shadow-lg" id="dropdownMenu">
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2">Dashboard</a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2">Edit Profile</a>
                        <form method="POST" action="/logout">
                            @csrf
                            @method('DELETE')
                            <button class="cursor-pointer block px-4 py-2 text-red-500">Log Out</button>
                        </form>
                    </div>
                </div>
            
                
            </div>
            
            <script>
                document.getElementById('categorySearch').addEventListener('input', function() {
                const filter = this.value.toLowerCase();
                const links = document.querySelectorAll('#categoriesDropdown a');
                
                links.forEach(link => {
                    const text = link.textContent.toLowerCase();
                    link.style.display = text.includes(filter) ? '' : 'none';
                });
            });
                const btn = document.getElementById('categoriesButton');
                const dropdown = document.getElementById('categoriesDropdown');
                const icon = document.getElementById('categoriesIcon');

                btn.addEventListener('click', function (e) {
                    e.stopPropagation(); // prevent immediate close on click
                    dropdown.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                });

                // Close dropdown if clicking outside
                document.addEventListener('click', function (e) {
                    if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                    }
                });
                document.getElementById('profileButton').addEventListener('click', function() {
                    const dropdownMenu = document.getElementById('dropdownMenu');
                    const dropdownIcon = document.getElementById('dropdownIcon');
                
                    // Toggle the visibility of the dropdown menu
                    dropdownMenu.classList.toggle('hidden');
                
                    // Toggle the rotation of the icon (rotate to 90° when clicked)
                    dropdownIcon.classList.toggle('rotate-180');
                });
            
                // Optional: Close the dropdown menu when clicking outside
                document.addEventListener('click', function(event) {
                    const profileButton = document.getElementById('profileButton');
                    const dropdownMenu = document.getElementById('dropdownMenu');
                    
                    if (!profileButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.add('hidden');  // Hide the menu
                        dropdownIcon.classList.remove('rotate-90');  // Reset icon rotation
                    }
                });
            </script>
            @endauth
            @guest
            <div class="space-x-6 font-bold">
                <a href="/register">signup</a>
                <a href="/login">login</a>
            </div>
            @endguest
        </nav>
        <main class="mt-10 max-w-[986px] mx-auto">
            {{$slot}}
        </main>
    </div>
</body>
</html>