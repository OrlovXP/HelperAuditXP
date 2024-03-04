@extends('layouts.app')

@section('content')

    @if(Session::has('success'))
        <div id="alert-3"
             class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-200"
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
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-200 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 inline-flex items-center justify-center h-8 w-8"
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





    <section>

        <x-form.table-wrapper>





            <div class="flex justify-between mb-8">
                <div class="inline-flex rounded-md" role="group">

                    <button id="all-deals-filter" type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-50 focus:z-10 focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30">
                        Все сделки {{ count($reports) }}
                    </button>
                    <button id="status-filter" type="button" data-status="Ready for exchange"
                            class="flex items-center px-4 py-2 text-sm font-medium text-green-500 bg-white border-t border-b border-r border-gray-200 hover:bg-gray-50 focus:z-10 focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30">
                        <span class="flex w-2 h-2 me-2 bg-green-500 rounded-full"></span>
                        Сделка готова к обмену {{ $readyForExchangeDealsCount }}
                    </button>
                    <button id="status-filter" type="button" data-status="Amounts are not equal"
                            class="flex items-center px-4 py-2 text-sm font-medium text-yellow-400 bg-white border-t border-b border-gray-200 hover:bg-gray-50 focus:z-10 focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30">
                        <span class="flex w-2 h-2 me-2 bg-yellow-400 rounded-full"></span>
                        Суммы по продукту не равны {{ $amountsNotEqualDealsCount }}
                    </button>
                    <button id="status-filter" type="button" data-status="Not found"
                            class="flex items-center px-4 py-2 text-sm font-medium text-red-500 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-50 focus:z-10 focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30">
                        <span class="flex w-2 h-2 me-2 bg-red-500 rounded-full"></span>
                        Сделка не найдена {{ $notFoundDealsCount }}
                    </button>
                </div>


                <div class="flex gap-3">
                    <a class="flex items-center px-4 py-2 font-medium text-sm text-gray-500 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-gray-50 focus:z-10"
                       href="{{ route('update.reports', $category->id) }}">

                        <x-svg class="me-2 text-gray-700">
                            <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                            <path d="M3 3v5h5"></path>
                            <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"></path>
                            <path d="M16 16h5v5"></path>
                        </x-svg>
                        Обновить
                    </a>
                    <a class="flex items-center px-4 py-2 font-medium text-sm text-gray-500 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-gray-50 focus:z-10"
                       href="#">

                        <x-svg class="me-2 text-gray-700">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" x2="12" y1="3" y2="15"></line>
                        </x-svg>
                        Выгрузить в CRM
                    </a>
                </div>

            </div>

            <div class="menu-item text-sm text-gray-500">
                Найдено сделок: {{ count($reports) }}, сумму вознаграждения:
                <x-sum>{{ number_format($totalReward, 2, '.', ' ') }}</x-sum>
            </div>

            <x-form.table id="sort-table">
                <thead>
                <tr class="border-b">
                    <x-table.th scope="col">#</x-table.th>
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
                    <tr data-status="{{ $report->status }}" class="border-b border-gray-300/50 hover:bg-[#13A2AF]/10"
                        id="row_{{ $loop->iteration }}" onclick="toggleRowColor('{{ $loop->iteration }}')">

                        <x-table.td
                                class="hover:cursor-pointer border-r text-center">{{ $loop->iteration }}</x-table.td>
                        <x-table.td>{{ $report->inn}}</x-table.td>
                        <x-table.td>

                            @if(isset($report->crm_company_id))
                                <a class="text-[#13A2AF] whitespace-normal" target="_blank"
                                   href="https://sckontur.bitrix24.ru/crm/company/details/{{ $report->crm_company_id }}/">
                                    {{ Str::limit($report->name, 30) }}
                                </a>
                            @else
                                {{ Str::limit($report->name, 30) }}
                            @endif


                        </x-table.td>
                        <x-table.td>
                            @if(isset($report->crm_deal_id))
                                <a class="text-[#13A2AF] whitespace-normal" target="_blank"
                                   href="https://sckontur.bitrix24.ru/crm/deal/details/{{ $report->crm_deal_id }}/">
                                    {{ $report->check }}
                                </a>
                            @else
                                {{ $report->check }}
                            @endif
                        </x-table.td>
                        <x-table.td>
                            <x-sum>{{ number_format($report->sum, 2, '.', ' ') }}</x-sum>
                        </x-table.td>
                        <x-table.td>
                            <x-sum>{{ number_format($report->reward, 2, '.', ' ') }}</x-sum>
                        </x-table.td>
                        <x-table.td>{{ $report->report_date }}</x-table.td>
                        <x-table.td>{{ $report->role }}</x-table.td>
                        <x-table.td>{{ $report->type }}</x-table.td>
                        <x-table.td>{{ $report->product }}</x-table.td>
                        <x-table.td>

                            @if($report->status === 'Ready for exchange')
                                <span class="flex w-2 h-2 bg-green-500 rounded-full"></span>
                            @elseif($report->status === 'Not found')
                                <span class="flex w-2 h-2 bg-red-500 rounded-full"></span>
                            @elseif($report->status === 'Amounts are not equal')
                                <span class="flex w-2 h-2 bg-yellow-400 rounded-full"></span>
                            @else
                                <span class="flex w-2 h-2 bg-gray-300 rounded-full"></span>
                            @endif
                        </x-table.td>


                    </tr>
                @endforeach

                </tbody>
            </x-form.table>

        </x-form.table-wrapper>

    </section>



    <script>
        function toggleRowColor(rowId) {
            const row = document.getElementById('row_' + rowId);
            row.classList.toggle('bg-[#13A2AF]/10'); // Замените 'bg-gray-200' на ваш класс для изменения цвета
        }


        document.addEventListener('DOMContentLoaded', function () {
            const statusButtons = document.querySelectorAll('#status-filter');

            statusButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const status = this.getAttribute('data-status');
                    filterByStatus(status);
                });
            });

            const allDealsFilterButton = document.getElementById('all-deals-filter');

            allDealsFilterButton.addEventListener('click', function () {
                filterByStatus('all');
            });

        });

        function filterByStatus(status) {
            const rows = document.querySelectorAll('tbody tr');


            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (rowStatus === status || status === 'all') {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }


    </script>

@endsection
