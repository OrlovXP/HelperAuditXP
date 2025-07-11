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

    {{--@dump($category)--}}
    <section>



        <x-form.table-wrapper>

            <div class="mb-12 border rounded-lg">

                <x-form.table>
                    <thead>
                    <tr class="text-base">
                        <x-table.th colspan="7">

                            <div class="text-base font-bold">
                                Статистика по отчёту за {{ $category->report_date }}
                            </div>


                        </x-table.th>
                        <x-table.th colspan="2" class="border-l border-r text-center">Соответствие CRM</x-table.th>
                        <x-table.th colspan="4" class="border-l text-center">Нет в CRM</x-table.th>

                    </tr>
                    <tr class="border-b">
                        <x-table.th scope="col" class="font-normal">Дата отчета</x-table.th>
                        <x-table.th scope="col" class="font-normal">Сумма по продукту</x-table.th>
                        <x-table.th scope="col" class="font-normal">Вознаграждения</x-table.th>
                        <x-table.th scope="col" class="font-normal">Кол-во сделок</x-table.th>
                        <x-table.th scope="col" class="font-normal">L-сделок</x-table.th>
                        <x-table.th scope="col" class="font-normal">S-сделок</x-table.th>
                        <x-table.th scope="col" class="font-normal">D-сделок</x-table.th>

                        <x-table.th scope="col" class="text-green-500 border-r border-l font-normal">Полное</x-table.th>
                        <x-table.th scope="col" class="text-orange-400 border-r border-l font-normal">Частичное
                        </x-table.th>

                        <x-table.th scope="col" class="text-red-500 border-r border-l font-normal">Всего</x-table.th>
                        <x-table.th scope="col" class="text-red-500 border-r border-l font-normal">L-сделки</x-table.th>
                        <x-table.th scope="col" class="text-red-500 border-r border-l font-normal">S-сделки</x-table.th>
                        <x-table.th scope="col" class="text-red-500 border-l font-normal">D-сделки</x-table.th>

                    </tr>
                    </thead>
                    <tbody>


                    <tr>
                        <x-table.td>
                            {{ $category->report_date }}
                        </x-table.td>
                        <x-table.td>
                            <x-sum>{{ number_format($totalSum, 2, '.', ' ') }}</x-sum>
                        </x-table.td>
                        <x-table.td>
                            <x-sum>{{ number_format($totalReward, 2, '.', ' ') }}</x-sum>
                        </x-table.td>
                        <x-table.td>{{ count($reports) }}</x-table.td>
                        <x-table.td> {{ $totallyLAgentElementsCount }}</x-table.td>
                        <x-table.td> {{ $totallySAgentElementsCount }}</x-table.td>
                        <x-table.td> {{ $totallyDAgentElementsCount }}</x-table.td>

                        <x-table.td
                            class="text-green-500 border-r border-l">{{ $readyForExchangeDealsCount }}</x-table.td>
                        <x-table.td
                            class="text-orange-400 border-r border-l">{{ $amountsNotEqualDealsCount }}</x-table.td>

                        <x-table.td class="text-red-500 border-r border-l">{{ $notFoundDealsCount }}</x-table.td>
                        <x-table.td class="text-red-500 border-r border-l">{{ $lAgentElementsCount }}</x-table.td>
                        <x-table.td class="text-red-500 border-r border-l">{{ $sAgentElementsCount }}</x-table.td>
                        <x-table.td class="text-red-500 border-l">{{ $dAgentElementsCount }}</x-table.td>


                    </tr>


                    </tbody>
                </x-form.table>
            </div>

            @if($category->is_statistics_saved)
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
                           href="{{ route('partial-update.reports', $category->id) }}">

                            <x-svg class="me-2 text-gray-700">
                                <path d="M21 12a9 9 0 1 1-9-9c2.52 0 4.93 1 6.74 2.74L21 8"></path>
                                <path d="M21 3v5h-5"></path>
                            </x-svg>
                            Проверить
                        </a>



                        @if($notFoundDealsCount && $amountsNotEqualDealsCount)
                            <a href="#"
                               class="flex items-center px-4 py-2 font-medium text-sm text-gray-500 bg-gray-50 border border-gray-200 rounded-lg pointer-events-none cursor-default">
                                <x-svg class="me-2 text-gray-700">
                                    <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                                    <path d="M21 3v5h-5"></path>
                                    <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                                    <path d="M8 16H3v5"></path>
                                </x-svg>
                                Синхронизировать отчет
                            </a>
                        @else
                            <a class="flex items-center px-4 py-2 font-medium text-sm text-gray-500 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-gray-50 focus:z-10"
                               href="{{ route('update.reports', $category->id) }}">

                                <x-svg class="me-2 text-gray-700">
                                    <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                                    <path d="M21 3v5h-5"></path>
                                    <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                                    <path d="M8 16H3v5"></path>
                                </x-svg>
                                Синхронизировать отчет
                            </a>

                        @endif



                        @if(count($reports) == $readyForExchangeDealsCount)
                            <a class="flex items-center px-4 py-2 font-medium text-sm text-gray-500 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-gray-50 focus:z-10"
                               href="{{ route('update.deals', $category->id) }}">

                                <x-svg class="me-2 text-gray-700">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" x2="12" y1="3" y2="15"></line>
                                </x-svg>
                                Выгрузить в CRM
                            </a>
                        @else
                            <a href="#"
                               class="flex items-center px-4 py-2 font-medium text-sm text-gray-500 bg-gray-50 border border-gray-200 rounded-lg pointer-events-none cursor-default">
                                <x-svg class="me-2 text-gray-700">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" x2="12" y1="3" y2="15"></line>
                                </x-svg>
                                Выгрузить в CRM
                            </a>
                        @endif

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
                        <x-table.th class="cursor-pointer" scope="col" id="sort-inn-button">ИНН</x-table.th>
                        <x-table.th class="cursor-pointer" scope="col" id="sort-name-button">Название</x-table.th>
                        <x-table.th class="cursor-pointer" scope="col" id="sort-check-button">Счёт</x-table.th>
                        <x-table.th scope="col">Сумма</x-table.th>
                        <x-table.th class="cursor-pointer" scope="col" id="sort-reward-button">Вознаграждение
                        </x-table.th>
                        <x-table.th scope="col">Дата отчета</x-table.th>
                        <x-table.th scope="col">Роль СЦ</x-table.th>
                        <x-table.th scope="col">Тип продажи</x-table.th>
                        <x-table.th scope="col">Продукт</x-table.th>
                        <x-table.th scope="col">Статус</x-table.th>


                    </tr>
                    </thead>
                    <tbody>

                    @foreach($reports as $report)
                        <tr data-status="{{ $report->status }}"
                            class="border-b border-gray-300/50 hover:bg-[#13A2AF]/10"
                            id="row_{{ $loop->iteration }}" onclick="toggleRowColor('{{ $loop->iteration }}')">

                            <x-table.td
                                class="hover:cursor-pointer border-r text-center">{{ $loop->iteration }}</x-table.td>
                            <x-table.td>{{ $report->inn }}</x-table.td>
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
            @else
                <div class="flex flex-col gap-2 items-center">
                    <div class="mb-4 text-sm">
                        Прежде чем начать работу с отчетом синхронизируйте и сохраните его.
                    </div>
                    <div class="flex flex-row gap-4">


                        {{--                        "is_statistics_saved" => 0--}}
                        {{--                        "is_statistics_loaded_crm" => 0--}}
                        {{--                        тут--}}

                        {{--                        php artisan make:migration add_is_statistics_synchronized_to_report_categories_table --table=report_categories--}}
                        {{--                        is_statistics_synchronized--}}
                        {{--                        {{ $category->is_statistics_synchronized }}--}}

                        @if(!$category->is_statistics_synchronized)
                            <a id="update-reports" class="flex items-center px-4 py-2 font-medium text-sm text-gray-500 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-gray-50 focus:z-10"
                               href="{{ route('update.reports', $category->id) }}">

                                <x-svg class="me-2 text-gray-700">
                                    <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                    <path d="M3 3v5h5"></path>
                                    <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"></path>
                                    <path d="M16 16h5v5"></path>
                                </x-svg>
                                Синхронизировать отчет
                            </a>
                        @else
                            <form action="{{ route('report-categories.update', $category->id) }}" method="post">
                                @csrf
                                @method('PUT')

                                <input type="text" name="total_sum" value="{{ $totalSum }}" hidden>
                                <input type="text" name="total_reward" value="{{ $totalReward }}" hidden>
                                <input type="text" name="total_deals" value="{{ count($reports) }}" hidden>

                                <input type="text" name="total_l_deals" value="{{ $totallyLAgentElementsCount }}"
                                       hidden>
                                <input type="text" name="total_s_deals" value="{{ $totallySAgentElementsCount }}"
                                       hidden>
                                <input type="text" name="total_d_deals" value="{{ $totallyDAgentElementsCount }}"
                                       hidden>

                                <input type="text" name="crm_full_compliance" value="{{ $readyForExchangeDealsCount }}"
                                       hidden>
                                <input type="text" name="crm_partial_compliance"
                                       value="{{ $amountsNotEqualDealsCount }}"
                                       hidden>

                                <input type="text" name="crm_no_deals" value="{{ $notFoundDealsCount }}" hidden>
                                <input type="text" name="crm_no_l_deals" value="{{ $lAgentElementsCount }}" hidden>
                                <input type="text" name="crm_no_s_deals" value="{{ $sAgentElementsCount }}" hidden>
                                <input type="text" name="crm_no_d_deals" value="{{ $dAgentElementsCount }}" hidden>
                                <input type="text" name="is_statistics_saved" value="1" hidden>

                                <button {{ !$category->is_statistics_saved ? : 'disabled' }} type="submit"
                                        class="disabled:bg-gray-50 flex items-center px-4 py-2 font-medium text-sm text-gray-500 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-gray-50 focus:z-10">
                                    <x-svg class="me-2 text-gray-700">
                                        <path
                                            d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                        <polyline points="7 3 7 8 15 8"></polyline>
                                    </x-svg>
                                    Сохранить отчет

                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif


        </x-form.table-wrapper>

    </section>

    <div id="modal-overlay" class="hidden fixed right-0 bottom-0 top-0 left-0 w-full h-full z-100 bg-black opacity-50 flex items-center justify-center">
        <div id="countdown" class="text-white text-7xl font-bold"></div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', (event) => {
            let countdownElement = document.getElementById('countdown');
            let syncButton = document.getElementById('update-reports');
            let modalOverlay = document.getElementById('modal-overlay')

            syncButton.addEventListener('click', function (event) {
                event.preventDefault();

                modalOverlay.classList.remove('hidden'); // активируем модальное окно перед началом действия

                fetch(syncButton.href).then(function(response) {
                    if(response.ok){
                        let totalReports = {{ $reports->count() }};
                        let updateTimePerReportInSeconds = 0.5;
                        let totalUpdateTimeInSeconds = totalReports * updateTimePerReportInSeconds;

                        totalUpdateTimeInSeconds *= 1.3;

                        let intervalId = setInterval(function() {
                            totalUpdateTimeInSeconds -= 0.5;
                            let minutes = Math.floor(totalUpdateTimeInSeconds / 60);
                            let seconds = Math.round(totalUpdateTimeInSeconds % 60);

                            countdownElement.innerHTML = minutes + " мин. " + seconds + " сек.";

                            if (totalUpdateTimeInSeconds <= 0) {
                                clearInterval(intervalId);
                                countdownElement.innerHTML = "Время обновления завершено!";
                                modalOverlay.classList.add('hidden'); // скрываем модальное окно после действия
                                location.reload(); // перезагрузка страницы
                            }
                        }, 500);
                    } else {
                        console.error('HTTP Response is not ok');
                        modalOverlay.classList.add('hidden'); // скрываем модальное окно при возникновении ошибки
                    }
                }).catch(function(error) {
                    console.error('There has been a problem with your fetch operation: ' + error.message);
                    modalOverlay.classList.add('hidden'); // скрываем модальное окно при возникновении ошибки
                });
            });
        });




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
            const rows = document.querySelectorAll('#sort-table tbody tr');


            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (rowStatus === status || status === 'all') {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Функция для сортировки строк таблицы по значению ячейки "ИНН"

        function removeSpaces(text) {
            return text.replace(/\s/g, '');
        }

        let sortDirectionINN = 'desc'; // Изначально сортировка по ИНН по убыванию
        let sortDirectionName = 'desc'; // Изначально сортировка по названию по убыванию
        let sortDirectionCheck = 'desc'; // Изначально сортировка по счёту по убыванию
        let sortDirectionReward = 'desc'; // Изначально сортировка по вознаграждению по убыванию

        // Функция для сортировки строк таблицы по указанному столбцу и направлению
        function sortTable(columnIndex, sortDirection) {
            const rows = document.querySelectorAll('#sort-table tbody tr');

            const sortedRows = Array.from(rows).sort((a, b) => {
                let cellA = a.children[columnIndex].textContent.trim(); // Получаем значение ячейки
                let cellB = b.children[columnIndex].textContent.trim();

                if (!isNaN(parseFloat(cellA))) { // Проверяем, является ли значение числом
                    cellA = parseFloat(removeSpaces(cellA)); // Удаляем пробелы и преобразуем в число
                    cellB = parseFloat(removeSpaces(cellB)); // Удаляем пробелы и преобразуем в число
                }
                // Применяем числовое сравнение для сортировки по ИНН, Счёту и Вознаграждению
                if (columnIndex === 1 || columnIndex === 3 || columnIndex === 5) {
                    return sortDirection === 'asc' ? cellA - cellB : cellB - cellA;
                }
                // Применяем лексикографическое сравнение для сортировки по Названию
                if (columnIndex === 2) {
                    return sortDirection === 'asc' ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
                }
            });

            // Удаляем текущие строки и добавляем отсортированные строки
            const tbody = document.querySelector('#sort-table tbody');
            tbody.innerHTML = '';
            sortedRows.forEach(row => {
                tbody.appendChild(row);
            });
        }

        // Назначаем обработчики событий на кнопки для сортировки по ИНН, Названию, Счёту и Вознаграждению
        const sortINNButton = document.getElementById('sort-inn-button');
        sortINNButton.addEventListener('click', () => {
            sortDirectionINN = sortDirectionINN === 'asc' ? 'desc' : 'asc'; // Изменяем направление сортировки
            sortTable(1, sortDirectionINN); // Вызываем функцию сортировки для столбца с ИНН
        });

        const sortNameButton = document.getElementById('sort-name-button');
        sortNameButton.addEventListener('click', () => {
            sortDirectionName = sortDirectionName === 'asc' ? 'desc' : 'asc'; // Изменяем направление сортировки
            sortTable(2, sortDirectionName); // Вызываем функцию сортировки для столбца с названием
        });

        const sortCheckButton = document.getElementById('sort-check-button');
        sortCheckButton.addEventListener('click', () => {
            sortDirectionCheck = sortDirectionCheck === 'asc' ? 'desc' : 'asc'; // Изменяем направление сортировки
            sortTable(3, sortDirectionCheck); // Вызываем функцию сортировки для столбца с счётом
        });

        const sortRewardButton = document.getElementById('sort-reward-button');
        sortRewardButton.addEventListener('click', () => {
            sortDirectionReward = sortDirectionReward === 'asc' ? 'desc' : 'asc'; // Изменяем направление сортировки
            sortTable(5, sortDirectionReward); // Вызываем функцию сортировки для столбца с вознаграждением
        });


    </script>

@endsection
