<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Кабинет AuditXP</title>

    <link rel="icon" href="{{ asset('public/images/favicon.ico') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css"/>
    <script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.4.0/flowbite.min.js"></script>
    <link href="{{ asset('public/build/assets/app-BaMBIA93.css') }}" rel="stylesheet">
{{--    @vite('resources/css/app.css')--}}

</head>
<body>

<div class="flex overflow-x-hidden">

    <div class="w-[275px] fixed z-40 bg-[#161616] h-screen">
        <div class="px-6 h-[4rem] flex items-center">
            <a href="/">
                <img class="w-[120px]" src="{{ asset('public/images/logo.svg') }}" alt="">
            </a>
        </div>
        <aside class="mt-6 px-6">


            @if(auth()->user()->role->name === 'admin')
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
                        <x-menu.item href="{{ route('products.index') }}">{{ __('Продукты') }}</x-menu.item>
                        <x-menu.item href="{{ route('managers.index') }}">{{ __('Менеджеры') }}</x-menu.item>
                        <x-menu.item href="{{ route('timestamp.index') }}">{{ __('Запросы') }}</x-menu.item>
                    </ul>
                </div>
            @endif


            <div class="mb-7">
                <div class="text-gray-300 text-base mb-2">
                    {{ __('Отчёт АВ') }}
                </div>
                <ul class="menu-sec">
                    <x-menu.item href="{{ route('report-categories.index') }}">{{ __('Все') }}</x-menu.item>
                </ul>
            </div>


            <div class="mb-7">
                <div class="text-gray-300 text-base mb-2">
                    {{ __('Реестр') }}
                </div>
                <ul class="menu-sec">
                    <x-menu.item
                        href="{{ route('audit-organizations.index') }}">{{ __('Аудиторские организации') }}</x-menu.item>
                </ul>
            </div>

                <div class="mb-7">
                    <div class="text-gray-300 text-base mb-2">
                        {{ __('Инструменты') }}
                    </div>
                    <ul class="menu-sec">
                        <x-menu.item href="{{ route('deals.print') }}">{{ __('Просмотр сделки') }}</x-menu.item>
                    </ul>
                </div>

        </aside>
    </div>

    <div class="w-full pl-[290px] px-4 pb-4">
        <header class="h-[4rem] flex items-center justify-end">
            <div>
                @auth()

                    <button id="dropdownNameButton" data-dropdown-toggle="dropdownName"
                            class="flex items-center pe-1 rounded-full md:me-0 focus:ring-0" type="button">

                        <div class="text-sm text-[#13A2AF]">
                            {{ Auth::user()->fio }}
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
        <main class="text-[#384253]">
            @yield('content')
        </main>
    </div>

</div>
<script src="{{ asset('public/build/assets/app-BSSnCqDo.js') }}"></script>
{{--@vite('resources/js/app.js')--}}
</body>
</html>
