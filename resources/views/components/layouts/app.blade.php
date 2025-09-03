{{-- <!DOCTYPE HTML> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="!bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Birthdays') }}</title>

    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <!-- Favicon -->
    <link rel="icon" href="{{ url('img/favicon.svg') }}">

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    @stack('styles')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="overflow-x-hidden bg-white">
<div id="app">
    @include('layouts.navigation')
    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset
    <main class="flex flex-col h-full">
        {{ $slot }}
    </main>
</div>

@livewireScripts

@stack('post-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@yield('scripts')

<!-- TOASTS -->
<div
    x-data="toastStore()"
    x-on:toast.window="add($event.detail)"
    class="fixed inset-0 pointer-events-none z-[9999]"
    aria-live="polite" aria-atomic="true"
>
    <!-- Stiva în dreapta-sus -->
    <div class="absolute top-4 right-4 flex flex-col gap-3 w-full sm:max-w-sm">
        <template x-for="t in toasts" :key="t.id">
            <div
                x-show="t.show"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2"
                class="pointer-events-auto rounded-2xl shadow-lg border p-4 bg-white dark:bg-neutral-900"
                :class="variantClasses(t.type)"
                role="status"
            >
                <div class="flex items-start gap-3">
                    <!-- Icon -->
                    <div class="mt-0.5" aria-hidden="true">
                        <template x-if="t.type === 'success'">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none"><path d="M20 7L9 18l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        </template>
                        <template x-if="t.type === 'error'">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none"><path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        </template>
                        <template x-if="t.type === 'warning'">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none"><path d="M12 9v4m0 4h.01M10.29 3.86l-8.59 14.86A2 2 0 0 0 3.42 22h17.16a2 2 0 0 0 1.72-3.28L13.71 3.86a2 2 0 0 0-3.42 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        </template>
                        <template x-if="t.type === 'info'">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none"><path d="M12 8h.01M11 12h1v4h1M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        </template>
                    </div>

                    <!-- Content -->
                    <div class="flex-1">
                        <p class="font-medium" x-text="t.title || titleByType(t.type)"></p>
                        <p class="text-sm opacity-80 mt-0.5" x-text="t.message"></p>
                    </div>

                    <!-- Close -->
                    <button
                        class="shrink-0 rounded-lg px-2 py-1 text-sm/none hover:bg-black/5 dark:hover:bg-white/10"
                        x-on:click="close(t.id)"
                        aria-label="Close"
                    >×</button>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('toastStore', () => ({
            toasts: [],
            counter: 0,
            defaultTimeout: 2800,

            add({ type = 'info', message = '', title = null, timeout = null } = {}) {
                const id = ++this.counter;
                const toast = { id, type, message, title, show: true };
                this.toasts.push(toast);

                const life = Number.isInteger(timeout) ? timeout : this.defaultTimeout;
                setTimeout(() => this.close(id), life);
            },

            close(id) {
                const t = this.toasts.find(x => x.id === id);
                if (!t) return;
                t.show = false;
                // elimină din array după animația de ieșire
                setTimeout(() => {
                    this.toasts = this.toasts.filter(x => x.id !== id);
                }, 160);
            },

            variantClasses(type) {
                switch (type) {
                    case 'success': return 'border-emerald-200 text-emerald-900 dark:text-emerald-100 dark:border-emerald-800';
                    case 'error':   return 'border-rose-200 text-rose-900 dark:text-rose-100 dark:border-rose-800';
                    case 'warning': return 'border-amber-200 text-amber-900 dark:text-amber-100 dark:border-amber-800';
                    default:        return 'border-slate-200 text-slate-900 dark:text-slate-100 dark:border-slate-800';
                }
            },

            titleByType(type) {
                switch (type) {
                    case 'success': return 'Success';
                    case 'error':   return 'Error';
                    case 'warning': return 'Warning';
                    default:        return 'Info';
                }
            },
        }))
    })
</script>

</body>
</html>
