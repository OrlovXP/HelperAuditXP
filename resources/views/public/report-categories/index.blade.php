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

        <h1>Агентские отчеты</h1>

        <x-form.table-wrapper>

            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data" class="max-w-lg font-normal">
                @csrf

                <div class="w-full flex justify-between bg-gray-100 rounded-md overflow-hidden">
                    <input type="file" name="file">
                    <button type="submit"
                            class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium px-5 text-center inline-flex items-center">
                        Импорт
                    </button>
                </div>
            </form>

            @if (!$categories->isEmpty())
                <div class="mb-8 border rounded-lg mt-4">
                    <x-form.table>
                        <thead>
                        <tr class="text-base">
                            <x-table.th colspan="7"></x-table.th>
                            <x-table.th colspan="2" class="border-l border-r text-center">Соответствие CRM</x-table.th>
                            <x-table.th colspan="4" class="border-l border-r text-center">Нет в CRM</x-table.th>

                        </tr>
                        <tr class="border-b">
                            <x-table.th scope="col" class="font-normal">Дата отчета</x-table.th>
                            <x-table.th scope="col" class="font-normal">Сумма по продукту</x-table.th>
                            <x-table.th scope="col" class="font-normal">Вознаграждения</x-table.th>
                            <x-table.th scope="col" class="font-normal">Кол-во сделок</x-table.th>
                            <x-table.th scope="col" class="font-normal">L-сделок</x-table.th>
                            <x-table.th scope="col" class="font-normal">S-сделок</x-table.th>
                            <x-table.th scope="col" class="font-normal">D-сделок</x-table.th>

                            <x-table.th scope="col" class="text-green-500 border-r border-l font-normal">Полное
                            </x-table.th>
                            <x-table.th scope="col" class="text-orange-400 border-r border-l font-normal">Частичное
                            </x-table.th>

                            <x-table.th scope="col" class="text-red-500 border-r border-l font-normal">Всего
                            </x-table.th>
                            <x-table.th scope="col" class="text-red-500 border-r border-l font-normal">L-сделки
                            </x-table.th>
                            <x-table.th scope="col" class="text-red-500 border-r border-l font-normal">S-сделки
                            </x-table.th>
                            <x-table.th scope="col" class="text-red-500 border-r border-l font-normal">D-сделки
                            </x-table.th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($categories as $category)
                            <tr class="border-b border-gray-300/50 hover:bg-[#13A2AF]/10 last:border-none">
                                <x-table.td>
                                    <a class="text-[#13A2AF]"
                                       href="{{ route('report-categories.show', $category->id) }}">{{ $category->report_date }}</a>
                                </x-table.td>
                                <x-table.td>
                                    @if($category->total_sum)
                                        <x-sum>{{ number_format($category->total_sum, 2, '.', ' ') }}</x-sum>
                                    @else
                                        {{ 'нет данных' }}
                                    @endif
                                </x-table.td>
                                <x-table.td>
                                    @if($category->total_reward)
                                        <x-sum>{{ number_format($category->total_reward, 2, '.', ' ') }}</x-sum>
                                    @else
                                        {{ 'нет данных' }}
                                    @endif
                                </x-table.td>
                                <x-table.td>{{ $category->total_deals ? :'нет данных' }}</x-table.td>
                                <x-table.td>{{ $category->total_l_deals ? : 'нет данных' }}</x-table.td>
                                <x-table.td>{{ $category->total_s_deals ? : 'нет данных' }}</x-table.td>
                                <x-table.td>{{ $category->total_d_deals ? : 'нет данных' }}</x-table.td>

                                <x-table.td
                                    class="text-green-500 border-r border-l">{{ $category->crm_full_compliance ? :'нет данных' }}</x-table.td>
                                <x-table.td
                                    class="text-orange-400 border-r border-l">{{ $category->crm_partial_compliance ? : 'нет данных' }}</x-table.td>

                                <x-table.td class="text-red-500 border-r border-l">{{ $category->crm_no_deals ? : 'нет данных' }}</x-table.td>
                                <x-table.td class="text-red-500 border-r border-l">{{ $category->crm_no_l_deals ? : 'нет данных' }}</x-table.td>
                                <x-table.td class="text-red-500 border-r border-l">{{ $category->crm_no_s_deals ? : 'нет данных' }}</x-table.td>
                                <x-table.td class="text-red-500 border-r border-l">{{ $category->crm_no_d_deals ? : 'нет данных' }}</x-table.td>
                                <x-table.td class="text-red-500">
                                    <button id="dropdownMenuIconButton"
                                            data-dropdown-toggle="dropdown-{{ $category->id }}"
                                            class="inline-flex items-center text-sm text-center text-gray-600 focus:ring-0 focus:outline-none"
                                            type="button">
                                        <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                             fill="currentColor"
                                             viewBox="0 0 4 15">
                                            <path
                                                d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                                        </svg>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div id="dropdown-{{ $category->id }}" class="z-10 hidden">
                                        <ul class="text-sm flex flex-col gap-1"
                                            aria-labelledby="dropdownMenuIconButton">


                                            <li>
                                                <form
                                                    action="{{ route('report-categories.destroy', ['id' => $category->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 block rounded-full p-1">
                                                        <x-svg class="text-white">
                                                            <path d="M3 6h18"></path>
                                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                                            <line x1="10" x2="10" y1="11" y2="17"></line>
                                                            <line x1="14" x2="14" y1="11" y2="17"></line>
                                                        </x-svg>
                                                    </button>
                                                </form>

                                            </li>
                                        </ul>

                                    </div>
                                </x-table.td>

                            </tr>
                        @endforeach

                        </tbody>
                    </x-form.table>
                </div>
            @endif


        </x-form.table-wrapper>

    </section>




    <script>

        // Получаем все строки таблицы, кроме заголовков
        const rows = document.querySelectorAll('tbody tr');

        // Проходим по каждой строке, начиная с первой
        for (let i = 0; i < rows.length - 1; i++) {
            const currentRow = rows[i];
            const nextRow = rows[i + 1];

            // Получаем ячейки текущей строки и следующей строки
            const currentCells = currentRow.querySelectorAll('td');
            const nextCells = nextRow.querySelectorAll('td');

            // Получаем значения суммы продукта и вознаграждений текущего и следующего месяцев
            const currentProductValue = parseFloat(currentCells[1].textContent.replace(/\s+/g, '').replace(',', '.'));
            const currentRewardValue = parseFloat(currentCells[2].textContent.replace(/\s+/g, '').replace(',', '.'));
            const nextProductValue = parseFloat(nextCells[1].textContent.replace(/\s+/g, '').replace(',', '.'));
            const nextRewardValue = parseFloat(nextCells[2].textContent.replace(/\s+/g, '').replace(',', '.'));

            // Создаем элементы для стрелок или кругов
            const productIndicator = document.createElement('span');
            const rewardIndicator = document.createElement('span');
            productIndicator.classList.add('indicator', 'ml-1', 'ml-0.5', 'rounded');
            rewardIndicator.classList.add('indicator', 'ml-1', 'ml-0.5', 'rounded');

            // Определяем направление стрелок или добавляем круги для суммы продукта
            if (currentProductValue > nextProductValue) {
                productIndicator.textContent = '↑';
                productIndicator.classList.add('arrow-up', 'text-green-500');
            } else if (currentProductValue < nextProductValue) {
                productIndicator.textContent = '↓';
                productIndicator.classList.add('arrow-down', 'text-red-500');
            }

            // Определяем направление стрелок или добавляем круги для вознаграждений
            if (currentRewardValue > nextRewardValue) {
                rewardIndicator.textContent = '↑';
                rewardIndicator.classList.add('arrow-up', 'text-green-500');
            } else if (currentRewardValue < nextRewardValue) {
                rewardIndicator.textContent = '↓';
                rewardIndicator.classList.add('arrow-down', 'text-red-500');
            }

            // Вставляем стрелки или круги в соответствующие ячейки
            currentCells[1].appendChild(productIndicator.cloneNode(true));
            currentCells[2].appendChild(rewardIndicator.cloneNode(true));
        }
    </script>

@endsection
