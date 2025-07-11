<x-layout>
    <section class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-center mb-6 text-white">Browse Jobs</h1>

        <!-- Search Bar -->
        <form method="GET" action="/search" class="flex justify-center mb-6">
            <input type="text" name="q" placeholder="Search for jobs..." 
                   class="w-1/2 border p-2 rounded shadow bg-black text-white border-white/20 focus:outline-none"
                   value="{{ request('q') }}">
                   
                   <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                Search
            </button>
        </form>

        <!-- Filtering Options -->
        <div class="w-auto flex justify-center space-x-3 mb-6 ">
            
                       
            <!-- Improved Buttons -->
            <button class="filter-btn px-4 py-2 text-sm font-semibold rounded border border-white/20 bg-white/10 text-white hover:bg-blue-600 hover:text-white transition">
                All
            </button>

            <button class="filter-btn px-4 py-2 text-sm font-semibold rounded border border-white/20 bg-white/10 text-green-400 hover:bg-green-600 hover:text-white transition"
                    onclick="updateFilter('location', 'Remote')">
                Remote
            </button>

            <button class="filter-btn px-4 py-2 text-sm font-semibold rounded border border-white/20 bg-white/10 text-yellow-400 hover:bg-yellow-600 hover:text-black transition"
                    onclick="updateFilter('schedule', 'Full Time')">
                Full Time
            </button>

            <button class="filter-btn px-4 py-2 text-sm font-semibold rounded border border-white/20 bg-white/10 text-red-400 hover:bg-red-600 hover:text-white transition"
                    onclick="updateFilter('schedule', 'Part Time')">
                Part Time
            </button>

            <select id="location-filter" class="bg-black text-green-500 border mt p-2 rounded shadow" onchange="updateLocation()">
                <option value="">Filter by Location</option>
                <option value="Iran" id="iran-option">Iran</option>
                <option value="Remote" id="remote-option">Remote</option>
            </select> 


            <!-- Salary Range Filter -->
            <select id="salary-filter" class="bg-black text-green-500 border p-2 rounded shadow" onchange="updateFilter('salary', this.value)">
                <option value="">Filter by Salary</option>
                <option value="0-50,000" {{ request('salary') == '0-50,000' ? 'selected' : '' }}>$0 - $50,000</option>
                <option value="50,000-90,000" {{ request('salary') == '50,000-90,000' ? 'selected' : '' }}>$50,000 - $90,000</option>
                <option value="90,000-150,000" {{ request('salary') == '90,000-150,000' ? 'selected' : '' }}>$90,000 - $150,000</option>
                <option value="150,000+" {{ request('salary') == '150,000+' ? 'selected' : '' }}>$150,000+</option>
            </select>
            
            <!-- Order By Filter -->
            <select id="order-by" class="bg-black text-green-500 border p-2 rounded shadow" onchange="updateFilter('order_by', this.value)">
                <option value="">Order By</option>
                <option value="salary_asc" {{ request('order_by') == 'salary_asc' ? 'selected' : '' }}>Salary: Low to High</option>
                <option value="salary_desc" {{ request('order_by') == 'salary_desc' ? 'selected' : '' }}>Salary: High to Low</option>
                <option value="title_asc" {{ request('order_by') == 'title_asc' ? 'selected' : '' }}>Title: A-Z</option>
                <option value="title_desc" {{ request('order_by') == 'title_desc' ? 'selected' : '' }}>Title: Z-A</option>
                <option value="date_desc" {{ request('order_by') == 'date_desc' ? 'selected' : '' }}>Newest First</option>
                <option value="date_asc" {{ request('order_by') == 'date_asc' ? 'selected' : '' }}>Oldest First</option>
            </select>
            
            <!-- Tags Filters -->
            <select id="category-filter" class="bg-black text-green-500 border p-2 rounded shadow" onchange="updateFilter('tag', this.value)">
                <option value="">Filter by Tag</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->name }}" {{ request('tag') == $tag->name ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Job Listings -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="job-list">
            @foreach($jobs as $job)
                <div class="p-6 bg-black border border-white/20 rounded-lg shadow-lg job-item">
                    <h3 class="text-xl font-bold text-white">{{ $job->title }}</h3>
                    <p class="text-gray-400">{{ $job->company }}</p>
                    <p class="text-sm text-gray-500">Created by: {{ $job->employer->name ?? 'Unknown' }}</p>

                    @if (!empty(optional($job->employer)->logo) && file_exists(storage_path('app/public/' . $job->employer->logo)))

                        <img src="{{ asset('storage/' .$job->employer->logo)}}" alt="Employer Image" class="mt-2 w-16 h-16 rounded-full">
                    @else
                        <img src="{{ asset( url('/images/default-user.png')) }}" alt="Default Employer Image" class="mt-2 w-16 h-16 rounded-full">
                    @endif

                    <p class="text-sm text-yellow-500">Location: {{ $job->location }}</p>
                    <p class="text-sm text-red-400">Schedule: {{ $job->schedule }}</p>
                    <p class="text-sm text-green-400">
                        Salary: $
                        {{ number_format((int) preg_replace('/[^0-9]/', '', $job->salary)) }}
                    </p>

                    <a href="{{ route('jobs.job-detail', $job->id) }}" 
                    class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all duration-200 shadow-md">
                        View Details
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center space-x-2">
            @if ($jobs->onFirstPage())
                <span class="px-3 py-2 bg-gray-700 text-white rounded">Previous</span>
            @else
                <a href="{{ $jobs->previousPageUrl() }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Previous</a>
            @endif

            @foreach ($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
                <a href="{{ $url }}" class="px-3 py-2 {{ $page == $jobs->currentPage() ? 'bg-green-500' : 'bg-gray-700' }} text-white rounded">
                    {{ $page }}
                </a>
            @endforeach

            @if ($jobs->hasMorePages())
                <a href="{{ $jobs->nextPageUrl() }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Next</a>
            @else
                <span class="px-3 py-2 bg-gray-700 text-white rounded">Next</span>
            @endif
        </div>
    </section>

    <script>
        function updateFilter(filterType, value) {
            let url = new URL(window.location.href);

            // Remove existing filter from URL
            url.searchParams.delete(filterType);

            // Add new filter if value is set
            if (value) {
                url.searchParams.append(filterType, value);
            }

            // Redirect to updated URL
            window.location.href = url;
        }

        function updateLocation() {
        const location = document.getElementById('location-filter').value;
        const url = new URL(window.location);

        // Update the URL based on the selected location
        if (location) {
            url.searchParams.set('location', location);  // Set query parameter
        } else {
            url.searchParams.delete('location');  // Remove query parameter if no selection
        }

        // Update the browser's URL without refreshing the page
        window.history.replaceState({}, '', url);

        // Redirect to updated URL
        window.location.href = url;
    }

    // Function to set the selected option based on the query parameter
    function setSelectedLocation() {
        const locationParam = new URLSearchParams(window.location.search).get('location');
        
        // Check if the location parameter exists in the URL and match it with the options
        if (locationParam === 'Iran') {
            document.getElementById('iran-option').selected = true;
        } else if (locationParam === 'Remote') {
            document.getElementById('remote-option').selected = true;
        }
    }

    function clearFilters() {
    let url = new URL(window.location.href);
    
    // Remove all search parameters
    url.searchParams.delete('q');
    url.searchParams.delete('tag');
    url.searchParams.delete('schedule');
    url.searchParams.delete('salary');
    url.searchParams.delete('location');
    url.searchParams.delete('order_by');
    url.searchParams.delete('category');
    
    // Redirect to the URL without filters
    window.location.href = url;
}


    // Call setSelectedLocation() when the page loads
    window.onload = setSelectedLocation;




    </script>
</x-layout>
