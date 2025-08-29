<div x-data="{ addBdModal : false }">
    @if ($birthdays)
        <div class="w-full p-4">
            @foreach ($birthdays as $bd)
                <div class="p-2 bg-gray-200 flex justify-between"><span>{{ $bd->name }}</span><span>{{  \Carbon\Carbon::parse($bd->date)->format('d M Y') }}</span></div>
            @endforeach
        </div>
    @endif
    <button @click="addBdModal=true" class="button">Add New Date</button>

    <div x-show="addBdModal=true" id="myModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto relative">
            <!-- Close button -->
            <button id="closeModalBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Modal Content -->
            <h2 class="text-xl font-semibold mb-4">Welcome to the Popup!</h2>
            <p class="text-gray-700 mb-6">This is a simple example of a modal created with Tailwind CSS and a bit of JavaScript.</p>
            <div class="flex justify-end">
                <button class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    Got It!
                </button>
            </div>
        </div>
    </div>
</div>
