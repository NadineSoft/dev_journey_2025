<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Birthdays') }}
        </h2>
    </x-slot>
    @livewire('birthday-list')
    @livewire('birthday-form')
</x-layouts.app>
