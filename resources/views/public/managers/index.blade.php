@extends('layouts.app')

@section('content')

    @if(Session::has('success'))
        <div id="alert-3"
             class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-300"
             role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                 viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                {{ Session::get('success') }}
            </div>
            <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 inline-flex items-center justify-center h-8 w-8"
                    data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    @if(Session::has('error'))
        <div id="alert-2"
             class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-200"
             role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                 viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                {{ Session::get('error') }}
            </div>
            <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-2" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>

    @endif



    <section>

        <h1>Менеджеры</h1>
        <x-form.table-wrapper>

            <div class="flex justify-end mb-4">
                <a class="flex items-center px-4 py-2 font-medium text-sm text-gray-500 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-gray-50 focus:z-10"
                   href="{{ route('managers.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="h-4 w-4 me-2 text-gray-700">
                        <path d="M5 12h14"/>
                        <path d="M12 5v14"/>
                    </svg>

                    Добавить менеджера
                </a>

            </div>

            <x-form.table>
                <thead>

                <tr class="border-b">
                    <x-table.th scope="col">ФИО</x-table.th>
                    <x-table.th scope="col">ID менеджера в биллинг</x-table.th>
                    <x-table.th scope="col">ID менеджера в crm</x-table.th>
                    <x-table.th scope="col">Активность</x-table.th>
                    <x-table.th scope="col">Действие</x-table.th>


                </tr>
                </thead>
                <tbody>


                @foreach($managers as $manager)
                    <tr class="border-b border-gray-300/50 hover:bg-[#13A2AF]/10 last:border-none">
                        <x-table.td>{{ $manager->name }}</x-table.td>
                        <x-table.td>{{ $manager->id_billing }}</x-table.td>
                        <x-table.td>{{ $manager->id_crm }}</x-table.td>
                        <x-table.td></x-table.td>
                        <x-table.td>
                            <div class="flex gap-1">
                                <div class="border rounded h-6 w-6 flex items-center justify-center bg-gray-50">
                                    <a href="{{ route('managers.edit', $manager->id) }}" class="flex items-center justify-center">
                                        <x-svg class="text-gray-500">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                                        </x-svg>
                                    </a>
                                </div>
                                <div class="border rounded h-6 w-6 flex items-center justify-center bg-gray-50">
                                    <form action="{{ route('managers.destroy', $manager->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 flex items-center justify-center">
                                            <x-svg class="text-red-800">
                                                <path d="M3 6h18"></path>
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                <line x1="10" x2="10" y1="11" y2="17"></line>
                                                <line x1="14" x2="14" y1="11" y2="17"></line>
                                            </x-svg>
                                        </button>
                                    </form>
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
