@extends('layouts.app')

@section('content')




    @if(Session::has('success'))
        <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                {{ Session::get('success') }}
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-200 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    @if(Session::has('error'))
        <div id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-red-400" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                {{ Session::get('error') }}
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-200 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-2" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>

    @endif


    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file">
        <button type="submit">Импорт</button>
    </form>

    <section>

        <x-form.table-wrapper>
            <x-form.table>
                <thead>
                <tr>
                    <x-table.th scope="col">ID</x-table.th>
                    <x-table.th scope="col">ИНН</x-table.th>
                    <x-table.th scope="col">Название</x-table.th>
                    <x-table.th scope="col">Счёт</x-table.th>
                    <x-table.th scope="col">Сумма</x-table.th>
                    <x-table.th scope="col">Вознаграждение</x-table.th>
                    <x-table.th scope="col">Дата отчета</x-table.th>
                    <x-table.th scope="col">Роль СЦ</x-table.th>
                    <x-table.th scope="col">Тип продажи</x-table.th>
                    <x-table.th scope="col">Продукт</x-table.th>
                    <x-table.th scope="col">Статус</x-table.th>


                </tr>
                </thead>
                <tbody>

                @foreach($reports as $report)
                    <tr class="border-b border-gray-300/50 last:border-none">

                        <x-table.td>{{ $report->id }}</x-table.td>
                        <x-table.td>{{ $report->inn}}</x-table.td>
                        <x-table.td><a class="text-[#13A2AF]" href="#">{{ $report->name }}</a></x-table.td>
                        <x-table.td><a class="text-[#13A2AF]" href="#">{{ $report->check }}</a></x-table.td>
                        <x-table.td><x-sum>{{ number_format($report->sum, 2, '.', ' ') }}</x-sum></x-table.td>
                        <x-table.td><x-sum>{{ number_format($report->reward, 2, '.', ' ') }}</x-sum></x-table.td>
                        <x-table.td>{{ $report->report_date }}</x-table.td>
                        <x-table.td>{{ $report->role }}</x-table.td>
                        <x-table.td>{{ $report->type }}</x-table.td>
                        <x-table.td>{{ $report->product }}</x-table.td>
                        <x-table.td>{{ $report->status }}</x-table.td>


                    </tr>
                @endforeach

                </tbody>
            </x-form.table>
        </x-form.table-wrapper>

    </section>
@endsection
