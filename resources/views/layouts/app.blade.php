@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="">
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

            const currentTheme = localStorage.getItem('theme') || lightTheme;
            htmlElement.setAttribute('data-theme', currentTheme);
            themeSwitcher.checked = currentTheme === darkTheme;

            themeSwitcher.addEventListener('change', (e) => {
                if (e.target.checked) {
                    htmlElement.setAttribute('data-theme', darkTheme);
                    localStorage.setItem('theme', darkTheme);
                } else {
                    htmlElement.setAttribute('data-theme', lightTheme);
                    localStorage.setItem('theme', lightTheme);
                }
            });
        });
        </script>

        @include('cookie-consent::index')
        @livewireScripts
    </body>
</html>
