<div class="max-w-6xl mx-auto px-4 py-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 bg-white rounded-2xl shadow-md p-4 md:p-6">

        <!-- Search Bar -->

        <!-- Search Bar -->
        <form method="GET" action="{{ route('customer.dashboard') }}" class="w-full md:w-2/3 relative">
            <input type="text" name="search" value="{{ request('search') }}" {{-- keep value after searching --}}
                placeholder="🔍 Search for flowers, gifts, or plants..."
                class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-200 shadow-sm
               focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none
               transition duration-200" />

            <!-- Search Icon -->
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18a7.5 7.5 0 006.15-1.35z" />
            </svg>
        </form>



        <!-- Category Filter -->
        <div class="w-full md:w-1/3 relative">
            <select
                class="appearance-none w-full px-4 py-2 rounded-full border border-gray-200 shadow-sm
               focus:ring-2 focus:ring-pink-500 focus:border-pink-500 focus:outline-none
               transition duration-200 pr-10">
                <option>All Categories</option>
                <option>Roses</option>
                <option>Tulips</option>
                <option>Orchids</option>
                <option>Bouquets</option>
            </select>
            <!-- Dropdown Icon -->
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>

    </div>
</div>
