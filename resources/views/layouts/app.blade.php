@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ session('theme', 'light') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MVPable') }}{{ $title ? ' | '.$title : '' }}</title>
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">

        <div class="min-h-screen bg-base-100">
            <x-theme-switcher.floating />

            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="py-6 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="py-6 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                 @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif
                {{ $slot }}
            </main>
        </div>
        <x-impersonate::banner/>
                <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeSwitcher = document.getElementById('theme-switcher');
            const htmlElement = document.documentElement;

            // themes
            const lightTheme = 'light';
            const darkTheme = 'dark';

            // Get theme from localStorage, honor the full 30+ themes
            const currentTheme = localStorage.getItem('theme') || lightTheme;
            htmlElement.setAttribute('data-theme', currentTheme);
            
            // Only set the basic switcher to dark if it's the dark theme
            if (themeSwitcher) {
                themeSwitcher.checked = currentTheme === darkTheme;
                
                themeSwitcher.addEventListener('change', (e) => {
                    const newTheme = e.target.checked ? darkTheme : lightTheme;
                    htmlElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                    
                    // Update session on the server for SSR consistency
                    fetch('/theme/update', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ theme: newTheme })
                    });
                });
            }
        });
        </script>

        @include('cookie-consent::index')
        @livewireScripts
    </body>
</html>
