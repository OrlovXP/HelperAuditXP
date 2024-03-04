@extends('layouts.app')

@section('content')
    <h1>Пользователи</h1>

    <section>



        <x-form.table-wrapper>
            <x-form.table>
                <thead>
                <tr>
                    <x-table.th scope="col">ID</x-table.th>
                    <x-table.th scope="col">Ф.И.О.</x-table.th>
                    <x-table.th scope="col">Почта</x-table.th>
                    <x-table.th scope="col">Активен</x-table.th>
                    <x-table.th scope="col">Действие</x-table.th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="border-b border-gray-300/50 last:border-none">
                        <x-table.td>{{ $user->id }}</x-table.td>
                        <x-table.td>{{ $user->last_name.' '.$user->first_name.' '.$user->middle_name}}</x-table.td>
                        <x-table.td>{{ $user->email }}</x-table.td>
                        <x-table.td>
                            @if($user->is_active)
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Да</span>
                            @else
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Нет</span>
                            @endif
                        </x-table.td>
                        <x-table.td>
                            <div class="flex">

                                <div class="flex py-2 border rounded-full">

                                    <a class="border-r px-3 last:border-none" href="#">
                                        <x-svg>
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                                        </x-svg>
                                    </a>

                                    <a class="border-r px-3 last:border-none" href="#">
                                        <x-svg class="text-red-800">
                                            <path d="M3 6h18"></path>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                            <line x1="10" x2="10" y1="11" y2="17"></line>
                                            <line x1="14" x2="14" y1="11" y2="17"></line>
                                        </x-svg>
                                    </a>
                                </div>
                            </div>
                        </x-table.td>
                    </tr>
                @endforeach
                </tbody>
            </x-form.table>
        </x-form.table-wrapper>
    </section>
@endsection
