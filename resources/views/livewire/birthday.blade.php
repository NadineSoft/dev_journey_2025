<div x-data="{ addBdModal: @entangle('addBdModal') }" class="p-8">
    @if ($birthdays)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-blue-400 border text-center px-8 py-4">
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Birthday</th>
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Notes</th>
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider"></th>
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider"></th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($birthdays as $bd)
                        <tr class="hover:bg-gray-50" wire:key="{{ $bd->id }}">
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">{{ $bd->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">{{  \Carbon\Carbon::parse($bd->date)->format('d M Y') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">{{ $bd->notes ?? '-' }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">
                                <x-icon-pencil class="icon-svg w-4 h-4" wire:click="showModal({{ $bd->id }})" />
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">
                                <x-icon-trash class="icon-svg w-4 h-4 text-red-800" wire:click="delete({{ $bd->id }})" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="mt-8">
        <button wire:click="showModal" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Add New Date</button>
    </div>

    <div x-show="addBdModal" x-cloak id="myModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto relative">
            <!-- Close button -->
            <button id="closeModalBtn" @click="addBdModal=false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Modal Content -->
            <h2 class="text-xl font-semibold mb-4">{{ $editId ? 'Edit the date' : 'Add new date' }}</h2>
            <p class="text-gray-700 mb-6">This is a simple description text.</p>
            <div class="form-group flex gap-4 flex-col">
                <input type="text" placeholder="Name" wire:model="name"
                       class="w-full border border-gray-300 rounded-[4px] h-10 px-3 text-sm text-neutral-weak placeholder:text-neutral-weak focus:ring-none focus:ring-transparent invalid:border-red-700 focus:invalid:border-red-700 focus:border-purple-1000 focus:rounded-[4px]" />
                <input type="date" wire:model="date"
                       class="w-full border border-gray-300 rounded-[4px] h-10 px-3 text-sm text-neutral-weak placeholder:text-neutral-weak focus:ring-none focus:ring-transparent invalid:border-red-700 focus:invalid:border-red-700 focus:border-purple-1000 focus:rounded-[4px]" />
                <textarea placeholder="Notes" wire:model="notes"
                       class="w-full border border-gray-300 rounded-[4px] h-10 px-3 text-sm text-neutral-weak placeholder:text-neutral-weak focus:ring-none focus:ring-transparent invalid:border-red-700 focus:invalid:border-red-700 focus:border-purple-1000 focus:rounded-[4px]"></textarea>

            </div>
            <div class="flex justify-between mt-8">
                <button wire:click="store" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    Save
                </button>
                <button @click="addBdModal=false" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
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
