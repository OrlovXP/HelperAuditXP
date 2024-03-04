<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css"/>
    <script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>

    @vite('resources/css/app.css')

</head>
<body>

<div class="flex">


    <div class="w-[275px] fixed z-40 bg-[#161616] h-screen">
        <div class="px-6 h-[4rem] flex items-center">
            <img class="w-[120px]" src="{{ asset('images/logo.svg') }}" alt="">
        </div>
        <aside class="mt-6 px-6">

            <div class="mb-7">
                <div class="text-gray-300 text-base mb-2">
                    {{ __('Пользователи') }}
                </div>
                <ul class="menu-sec">
                    <x-menu.item href="{{ route('users.index') }}">{{ __('Все') }}</x-menu.item>
                    <x-menu.item href="#">{{ __('Добавить') }}</x-menu.item>

                </ul>
            </div>


            <div class="mb-7">
                <div class="text-gray-300 text-base mb-2">
                    {{ __('Билли') }}
                </div>
                <ul class="menu-sec">
                    <x-menu.item href="#">{{ __('Продукты') }}</x-menu.item>
                    <x-menu.item href="#">{{ __('Менеджеры') }}</x-menu.item>
                    <x-menu.item href="#">{{ __('Запросы') }}</x-menu.item>
                </ul>
            </div>


            <div class="mb-7">
                <div class="text-gray-300 text-base mb-2">
                    {{ __('Отчёт АВ') }}
                </div>
                <ul class="menu-sec">
                    <x-menu.item href="{{ route('report-categories.index') }}">{{ __('Все') }}</x-menu.item>
                </ul>
            </div>


        </aside>
    </div>

    <div class="w-full ml-[275px] px-4 pb-4">
        <header class="h-[4rem] flex items-center justify-end">



            <div class="">
                @auth()

                    <button id="dropdownNameButton" data-dropdown-toggle="dropdownName"
                            class="flex items-center pe-1 rounded-full md:me-0 focus:ring-0" type="button">

                        <div class="text-sm text-[#13A2AF]">
                            {{ Auth::user()->email }}
                        </div>

                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownName" class="z-10 hidden bg-[#13A2AF] divide-y divide-gray-100 rounded-lg shadow">
                        <ul class="text-sm text-white" aria-labelledby="dropdownInformdropdownNameButtonationButton">

                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-white/20">
                                    <form class="p-0 m-0" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit">Выйти</button>
                                    </form>
                                </a>
                            </li>
                        </ul>

                    </div>

                @endauth
            </div>
        </header>
        <main class="text-[#384253] h-screen">
            @yield('content')
        </main>
    </div>



@vite('resources/js/app.js')
</body>
</html>
