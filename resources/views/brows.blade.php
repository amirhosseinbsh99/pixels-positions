<x-layout>
    <section class="container mx-auto p-6">
        <h1 class="text-4xl font-bold text-center mb-6 text-white">Browse Jobs</h1>

        <!-- Search Bar -->
        <div class="flex justify-center mb-6">
            <input type="text" id="search" placeholder="Search for jobs..." 
                   class="w-1/2 border p-2 rounded shadow bg-black text-white border-white/20 focus:outline-none">
        </div>

        <!-- Category Filters -->
        <div class="flex justify-center space-x-4 mb-6">
            <button class="filter-btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition" data-category="all">All</button>
            <button class="filter-btn bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition" data-category="remote">Remote</button>
            <button class="filter-btn bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition" data-category="full-time">Full-Time</button>
            <button class="filter-btn bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition" data-category="part-time">Part-Time</button>
        </div>

        <!-- Job Listings -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="job-list">
            @foreach($jobs as $job)
                <div class="p-6 bg-black border border-white/20 rounded-lg shadow-lg job-item" data-category="{{ $job->category->name ?? 'unknown' }}">
                    <h3 class="text-xl font-bold text-white">{{ $job->title }}</h3>
                    <p class="text-gray-400">{{ $job->company }}</p>
                    <p class="text-sm text-gray-500">{{ $job->location }}</p>
                    <a href="{{ route('jobs.job-detail', $job->id) }}" 
                       class="block mt-3 text-blue-500 hover:underline">View Details</a>
                </div>
            @endforeach
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("search");
            const jobItems = document.querySelectorAll(".job-item");
            const filterButtons = document.querySelectorAll(".filter-btn");

            searchInput.addEventListener("input", function () {
                const searchText = this.value.toLowerCase();
                jobItems.forEach(job => {
                    const title = job.querySelector("h3").textContent.toLowerCase();
                    job.style.display = title.includes(searchText) ? "block" : "none";
                });
            });

            filterButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const category = this.getAttribute("data-category");
                    jobItems.forEach(job => {
                        job.style.display = (category === "all" || job.dataset.category === category) ? "block" : "none";
                    });
                });
            });
        });
    </script>
</x-layout>
