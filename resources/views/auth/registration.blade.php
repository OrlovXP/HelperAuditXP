<x-layouts.auth.form>

    <x-slot:title>
        Регистрация
    </x-slot:title>

    <form class="space-y-4 md:space-y-6" action="{{ route('registration.store') }}" method="post">
        @csrf
        <div>
            <x-form.label for="fio">{{ __('ФИО:') }}</x-form.label>
            <x-form.text type="text" name="fio" id="fio"/>
        </div>

        <div>
            <x-form.label for="email">{{ __('Почта:') }}</x-form.label>
            <x-form.text type="email" name="email" id="email"/>
        </div>

        <div>
            <x-form.label for="password">{{ __('Пароль:') }}</x-form.label>
            <x-form.text type="password" name="password" id="password"/>
        </div>

        <x-button type="submit">{{ __('Зарегистрироваться') }}</x-button>

    </form>

    <x-slot:links>
        <div class="flex justify-between text-sm text-gray-500 mt-4">{{ __('Есть учетная запись!') }}
            <x-form.links to="{{ route('login.store') }}">
                {{ __('Авторизация') }}
            </x-form.links>
        </div>
    </x-slot:links>

</x-layouts.auth.form>
