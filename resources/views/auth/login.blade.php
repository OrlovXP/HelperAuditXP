<x-layouts.auth.form>

    <x-slot:title>
        Авторизация
    </x-slot:title>

    <form class="space-y-4 md:space-y-6" action="{{ route('login.store') }}" method="post">
        @csrf
        <div>
            <x-form.label for="email">{{ __('Почта:') }}</x-form.label>
            <x-form.text type="email" name="email" id="email" placeholder="name@company.com"/>
        </div>

        <div>
            <x-form.label for="password">{{ __('Пароль:') }}</x-form.label>
            <x-form.text type="password" name="password" id="password" placeholder="••••••••"/>
        </div>

        <x-button type="submit">{{ __('Войти') }}</x-button>

    </form>

    <x-slot:links>
        <div class="flex justify-between text-sm text-gray-500 mt-4">{{ __('У вас еще нет учетной записи?') }}
            <x-form.links to="{{ route('registration.store') }}">
                {{ __('Регистрация') }}
            </x-form.links>
        </div>
    </x-slot:links>

</x-layouts.auth.form>



