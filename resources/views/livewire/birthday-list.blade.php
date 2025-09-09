<div class="p-8">
    <div class="search flex relative mb-8 gap-4">
        <div class="relative flex-1">
            <input type="text" wire:model.live.debounce.500ms="search"
                   class="w-full flex-1 border border-gray-900 rounded-[4px] h-10 px-3 text-sm text-neutral-weak placeholder:text-neutral-weak focus:ring-none focus:ring-transparent invalid:border-red-700 focus:invalid:border-red-700 focus:border-purple-1000 focus:rounded-[4px]" />
            <x-icon-search class="w-4 h-4 icon-svg absolute right-2 my-auto top-0 bottom-0" />
        </div>
        <div class="">
            <select wire:model.live="range">
                <option value=""></option>
                <option value="this_week">This week</option>
                <option value="upcoming">Upcoming</option>
            </select>
        </div>
        <div>
            <button wire:click="$dispatch('openBirthdayForm')" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Add New Date</button>
        </div>

    </div>
    <div class="mb-8">
        @if (session()->has('message'))
            <div class="text-green-500 text-[11px] leading-3 pt-1 mt-4" role="alert">
                {{ session('message') }}
            </div>
        @endif
    </div>
    @if ($birthdays)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-blue-400 border text-center px-8 py-4">
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider"><div class="flex gap-2 cursor-pointer" wire:click="sortBy('name')">Name <x-icon-sort class="w-4 h-4 icons-svg" /></div></th>
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider"><div class="flex gap-2 cursor-pointer" wire:click="sortBy('date')">Birthday <x-icon-sort class="w-4 h-4 icon-svg" /></div></th>
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Image</th>
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Notes</th>
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider"></th>
                        <th class="py-2 px-4 bg-gray-100 border-b border-gray-200 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider"></th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($birthdays as $bd)
                        <tr class="hover:bg-gray-50" wire:key="{{ $bd->id }}">
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">{{ $bd->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">{{  $bd->displayDate }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">
                                @if ($bd->hasMedia('profile_image'))
                                    <img src="{{ $bd->getFirstMediaUrl('profile_image') }}" alt="{{ $bd->name }}" class="w-10 h-10 object-cover">
                                @else
                                    No image
                                @endif
                            </td>

                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">{{ $bd->notes ?? '' }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">
                                <x-icon-pencil class="icon-svg w-4 h-4 cursor-pointer" wire:click="$dispatch('editBirthday', { 'id' : {{ $bd->id }} })" />
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-gray-800">
                                @can ('delete', $bd)
                                    <x-icon-trash class="icon-svg w-4 h-4 text-red-800 cursor-pointer" wire:click="delete({{ $bd->id }})" />
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $birthdays->links() }}
        </div>
    @endif
 </div>
