<div x-data="{ showModal: @entangle('showModal') }" class="p-8">
    <div x-show="showModal" x-cloak id="myModal" class="fixed inset-0 bg-black/50 flex items-center justify-center"
         x-transition @keydown.escape.window="showModal=false"
    >
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto relative">
            <!-- Close button -->
            <button id="closeModalBtn" @click="showModal = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Modal Content -->
            <h2 class="text-xl font-semibold mb-4">{{ $birthdayId ? 'Edit the date' : 'Add new date' }}</h2>
            <p class="text-gray-700 mb-6">This is a simple description text.</p>
            <div class="form-group flex gap-4 flex-col">
                <input type="text" placeholder="Name" wire:model="name"
                       class="w-full border border-gray-300 rounded-[4px] h-10 px-3 text-sm text-neutral-weak placeholder:text-neutral-weak focus:ring-none focus:ring-transparent invalid:border-red-700 focus:invalid:border-red-700 focus:border-purple-1000 focus:rounded-[4px]" />
                <div class="flex justify-between gap-2">
                    <div>
                        <label for="day">Day</label>
                        <input id="day" wire:model="day" class="w-full border rounded-[4px] h-10 px-3 text-sm text-neutral-weak placeholder:text-neutral-weak focus:ring-none focus:ring-transparent {{ $errors->has('day') ? 'border-red-700' : 'border-gray-300' }} focus:border-purple-1000 focus:rounded-[4px]" />
                        @error('day')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="month">Month</label>
                        <input id="month" wire:model="month" class="w-full border rounded-[4px] h-10 px-3 text-sm text-neutral-weak placeholder:text-neutral-weak focus:ring-none focus:ring-transparent {{ $errors->has('month') ? 'border-red-700' : 'border-gray-300' }} focus:border-purple-1000 focus:rounded-[4px]" />
                        @error('month')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="year">Year</label>
                        <input id="year" wire:model="year" class="w-full border rounded-[4px] h-10 px-3 text-sm text-neutral-weak placeholder:text-neutral-weak focus:ring-none focus:ring-transparent {{ $errors->has('year') ? 'border-red-700' : 'border-gray-300' }} focus:border-purple-1000 focus:rounded-[4px]" />
                        @error('year')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <div class="mb-4">
                    <label for="avatar" class="block text-sm font-medium">Profile Image</label>
                    <input wire:model="avatar" id="avatar" type="file" accept="image/*" class="w-full border rounded p-2">
                    @error('avatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <textarea placeholder="Notes" wire:model="notes"
                       class="w-full border border-gray-300 rounded-[4px] h-10 px-3 text-sm text-neutral-weak placeholder:text-neutral-weak focus:ring-none focus:ring-transparent invalid:border-red-700 focus:invalid:border-red-700 focus:border-purple-1000 focus:rounded-[4px]"></textarea>

            </div>
            <div class="flex justify-between mt-8">
                <button wire:click="store" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    Save
                </button>
                <button @click="showModal=false" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    Close
                </button>
            </div>
            <div>
                @if (session()->has('error'))
                    <span class="text-red-700 text-sm" role="alert">
                        <strong>{{ session('error') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
