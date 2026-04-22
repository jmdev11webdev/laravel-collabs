<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('Welcome') }} - {{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />


        <!-- Styles -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-zinc-950">
        <header class="fixed top-0 w-full bg-zinc-900 border-b border-zinc-800 z-50">
            <div class="w-full max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
                <div class="font-bold flex items-center gap-2">
                    <img src="{{ asset('images/ai-generated-logo.png') }}" alt="Logo" class="h-10">
                    <h1 class="text-zinc-200 sm:text-xlg text-md">
                        LaravelCollabs
                    </h1>
                </div>
                <ul class="sm:flex hidden text-neutral-400 items-center gap-4 text-sm">
                    <li><a href="#home" class="hover:text-red-400 duration-300 ease-in-out">Home</a></li>
                    <li><a href="#updates" class="hover:text-red-400 duration-300 ease-in-out px-3 py-1.5">Updates</a></li>
                    <li><a href="#preview" class="hover:text-red-400 duration-300 ease-in-out px-3 py-1.5">Preview</a></li>
                    <li><a href="#support" class="hover:text-red-400 duration-300 ease-in-out px-3 py-1.5">Support</a></li>
                    <li><a href="https://www.github.com/jmdev11webdev/laravel-collabs" class="hover:text-red-400 duration-300 ease-in-out px-3 py-1.5">Contribute</a></li>
                    <li><a href="" class="text-emerald-400 hover:text-emerald-200 hover:bg-neutral-800/50 duration-300 ease-in-out px-3 py-1.5">Community</a></li>
                    <li><a href="" class="text-amber-400 hover:text-amber-200 hover:bg-neutral-800/50 duration-300 ease-in-out px-3 py-1.5">Hire a Developer</a></li>
                </ul>
                @if (Route::has('login'))
                    <nav class="sm:flex hidden items-center justify-end gap-4 ">
                        @auth
                            <a
                                href="{{ route('dashboard') }}"
                                class="inline-block px-5 py-1.5 text-zinc-950 bg-zinc-50 rounded-full sm:text-lg text-sm"
                            >
                                Dashboard
                            </a>
                        @else
                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="inline-block px-5 py-1.5 bg-white text-black rounded-md">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
                <!-- hamburger -->
                <button onclick="sidebarFunction()" class="text-white hover:text-red-400 sm:hidden block">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                    </svg>
                </button>
            </div>
        </header>

        <div id="side-bar" class="hidden fixed w-full bg-black/50 h-screen z-50 right-0">
            <nav class="flex flex-col bg-neutral-900 h-screen w-fit px-4 py-4 ml-auto border-l border-neutral-700">
                <ul class="text-neutral-200 gap-4 flex flex-col">
                    <li class="flex justify-between items-center">
                        <h1 class="uppercase pt-2 text-neutral-400">
                            Menu
                        </h1>
                        <button onclick="closeFunction()" class="pt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </button>
                    </svg>
                    </li>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#updates">Updates</a></li>
                    <li><a href="#preview">Preview</a></li>
                    <li><a href="#support">Support</a></li>
                    <li><a href="https://www.github.com/jmdev11webdev/laravel-collabs">Contribute</a></li>
                    <li><a href="" class="text-emerald-400 hover:bg-neutral-800/50 hover:text-emerald-200">Community</a></li>
                    <li><a href="" class="text-amber-400 hover:bg-neutral-800/50 hover:text-amber-200">Hire a Developer</a></li>
                </ul>

                <a href="{{ route('register') }}" class="text-center mt-auto">Get Started</a>
            </nav>
        </div>

        <!-- Hero Section -->
        <section id="home" class="flex justify-start pt-[100px] items-center flex-col text-center leading-7 min-h-screen gap-[100px]">
            <div class="flex items-center gap-2 bg-neutral-800 rounded-md px-2 py-2 text-sm border border-neutral-700">
                <button onclick="myDeveloper()" id="dev-btn" class="px-5 py-1.5 rounded-md bg-white text-black font-semibold transition-all duration-300 ease-in-out cursor-pointer">
                    I'm a Developer
                </button>
                <button onclick="myClient()" id="client-btn" class="px-5 py-1.5 rounded-md bg-white text-black font-semibold bg-gradient-to-r from-amber-300 to-orange-500 text-black transition-all duration-300 ease-in-out opacity-20 cursor-pointer">
                    I'm a Client
                </button>
            </div>
            
            <!-- developer wrapped div -->
            <div id="developer" class="w-full flex justify-center items-center flex-col gap-4 transition-all duration-300 ease-in-out">
                <h1 class="text-white sm:text-6xl text-4xl font-semibold">
                    Welcome, Laravel Collaborators!
                </h1>
                <p class="text-zinc-400 sm:text-3xl text-2xl sm:px-0 px-4">
                    Find, Collaborate, and Build with other developers!
                </p>
                <div class="flex sm:flex-row flex-col items-center gap-2">
                    <a href="#developers" class="flex items-center gap-1 text-black font-semibold px-3 py-1.5 bg-white rounded-md">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg> -->
                        Browse Developers
                    </a>
                    <a href="#post-projects" class="flex items-center gap-1 text-white border border-white px-3 py-1.5 bg-transparent rounded-md">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15m0-3-3-3m0 0-3 3m3-3V15" />
                        </svg> -->
                        Post Projects
                    </a>
                    <a href="#post-projects" class="flex items-center gap-1 px-3 py-1.5 bg-gradient-to-r from-amber-300 to-orange-500 text-black rounded-md">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg> -->
                        Contact Us
                    </a>
                </div>
                <div class="flex flex-col justify-between sm:flex-row mt-4 gap-4">
                    <div class="text-start bg-neutral-800 px-4 py-4 rounded-md border border-neutral-700">
                        <h1 class="font-bold text-white flex items-center gap-1 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            Find Talent
                        </h1>
                        <small class="text-neutral-400">
                            Browse vetted Laravel devs by skill or stack
                        </small>
                    </div>

                    <div class="text-start bg-neutral-800 px-4 py-4 rounded-md border border-neutral-700">
                        <h1 class="font-bold text-white">
                            Collaborate
                        </h1>
                        <small class="text-neutral-400">
                            Team up on open source or client projects
                        </small>
                    </div>

                    <div class="text-start bg-neutral-800 px-4 py-4 rounded-md border border-neutral-700">
                        <h1 class="font-bold text-white">
                            Deploy and Share
                        </h1>
                        <small class="text-neutral-400">
                            Deploy and share to the community
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- client wrapped div -->
            <div id="client" class="hidden flex justify-center items-center flex-col gap-4 transition-all duration-300 ease-in-out">
                <h1 class="text-white sm:text-6xl text-2xl font-semibold">
                    Welcome, dear Clients!
                </h1>
                <p class="text-zinc-400 sm:text-3xl sm:px-0 px-8">
                    Find, Inquire, and Hire Laravel developers!
                </p>
                <div class="flex sm:flex-row flex-col items-center gap-2">
                    <a href="#developers" class="flex items-center gap-1 text-black font-semibold px-3 py-1.5 bg-white rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        Browse Developers
                    </a>
                    <a href="#post-projects" class="flex items-center gap-1 text-white border border-white px-3 py-1.5 bg-transparent rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15m0-3-3-3m0 0-3 3m3-3V15" />
                        </svg>
                        Post Projects
                    </a>
                </div>
            </div>
        </section>

        <section id="updates" class="h-screen w-full flex justify-center items-center flex-col text-center leading-7">
            <h1 class="flex items-center gap-2 text-white text-3xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                </svg>
                Updates
            </h1>

            <p class="text-zinc-400">
                No new updates yet...
            </p>
        </section>

        <section id="preview" class="h-screen w-full flex justify-center items-center flex-col text-center leading-7">
            <h1 class="flex items-center gap-2 text-white text-3xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                Preview
            </h1>
        </section>
        
        <!-- @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif -->

        <footer class="bg-transparent w-full px-4 py-4">
            <h1 class="text-zinc-400 text-center">
                &copy; 2026 Laravel Collabs. All Rights Reserved.
            </h1>
        </footer>

        <script>
            function myDeveloper() {
                document.getElementById('developer').style="display:flex;";
                document.getElementById('client').style="display:none;";
                document.getElementById('client-btn').classList.add('opacity-20')
                document.getElementById('dev-btn').classList.remove('opacity-20')
            }

            function myClient() {
                document.getElementById('client').style="display:flex;";
                document.getElementById('developer').style="display:none;";
                document.getElementById('dev-btn').classList.add('opacity-20')
                document.getElementById('client-btn').classList.remove('opacity-20')
            }

            function sidebarFunction(){
                document.getElementById('side-bar').style="display:block;";
            }

            function closeFunction() {
                document.getElementById('side-bar').style="display:none";
            }
        </script>
    </body>
</html>
