<x-layout>
    <section class="text-center">
        <h1 class="text-4xl font-bold mb-4">Contact Us</h1>
        <p class="text-gray-400 mb-6">Have questions? Reach out to us.</p>

        <div class="grid md:grid-cols-2 gap-8 mt-8">
            <!-- Contact Information -->
            <div class="space-y-4 text-left">
                <p><strong>Email:</strong> <a href="mailto:support@example.com" class="text-blue-500">support@example.com</a></p>
                <p><strong>Phone:</strong> +1 (234) 567-890</p>
                <p><strong>Address:</strong> 1234 Job Street, Work City, WC 56789</p>
            </div>

            <!-- Contact Form -->
            <div class="bg-white text-black p-6 rounded-lg shadow-lg">
                <form id="contactForm">
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Your Name</label>
                        <input type="text" name="name" class="w-full border p-2 rounded mt-1">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Your Email</label>
                        <input type="email" name="email" class="w-full border p-2 rounded mt-1">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Message</label>
                        <textarea name="message" class="w-full border p-2 rounded mt-1" rows="4"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full">Send Message</button>
                    <p id="successMessage" class="text-green-500 mt-3 hidden">Message Sent!</p>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.getElementById("contactForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent actual form submission
            
            // Show success message
            document.getElementById("successMessage").classList.remove("hidden");

            // Optionally, clear the form fields
            this.reset();
        });
    </script>
</x-layout>
