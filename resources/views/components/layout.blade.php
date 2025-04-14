<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pixel Postions</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-black text-white pb-20">
    <div class="px-10">
        <nav class="flex justify-between items-center py-4 border-b border-white/10">
            <div>
                <a href="/">
                    <img src="{{ Vite::asset('resources/images/logo.svg')}}" alt="">
                </a>
            </div>
            <div class="ml-65 space-x-6 font-bold">
                <a href="/">Home</a>
                <a href="/search">Browse Jobs</a>
                <a href="/aboutus">About Us</a>
                <a href="/contact">Contact</a>
            </div>
            @auth
                
        
            <div class="space-x-6 font-bold flex">
                <a href="/jobs/create">Post a job</a>
                
                <!-- Dropdown for My Profile -->
                <div class="relative">
                    <button class="flex items-center cursor-pointer" id="profileButton">
                        <!-- Dropdown icon (Initially pointing right) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 mr-2 w-4 h-4 transform transition-transform duration-200" id="dropdownIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        My Profile
                    </button>
            
                    <!-- Dropdown menu (Hidden by default) -->
                    <div class="absolute hidden bg-black text-white border rounded shadow-lg" id="dropdownMenu">
                        <a href="/profile/edit" class="block px-4 py-2">Dashboard</a>
                        <a href="/profile/settings" class="block px-4 py-2">Edit Profile</a>
                        <a href="/profile/notifications" class="block px-4 py-2">Notifications</a>
                    </div>
                </div>
            
                <form method="POST" action="/logout">
                    @csrf
                    @method('DELETE')
                    <button class="cursor-pointer">Log Out</button>
                </form>
            </div>
            
            <script>
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