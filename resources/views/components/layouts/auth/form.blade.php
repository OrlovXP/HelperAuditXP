<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    <link href="{{ asset('public/build/assets/app-BaMBIA93.css') }}" rel="stylesheet">
    {{--    @vite('resources/css/app.css')--}}

</head>
<body>

<section>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

        <div class="mb-6">
            <img class="w-[180px]" src="{{ asset('public/images/logo.svg') }}" alt="">
        </div>


        <div class="w-full md:mt-0 sm:max-w-md xl:p-0">
            <div class="bg-white rounded-lg shadow-2xl shadow-black/10">

                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">

                    <h1 class="text-2xl">
                        {{ $title }}
                    </h1>

                    {{ $slot }}



                </div>
            </div>
            {{ $links }}
        </div>

    </div>
</section>

<script src="{{ asset('public/build/assets/app-BSSnCqDo.js') }}"></script>
{{--@vite('resources/js/app.js')--}}
</body>
</html>
