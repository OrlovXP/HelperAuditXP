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
                    class="ms-auto -mx-1.5 -my-1.5 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 inline-flex items-center justify-center h-8 w-8"
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

    <form method="POST" action="{{ route('audit-organizations.update', ['basic_inn' => $register->basic_inn]) }}">
        @csrf
        @method('POST')
        <button type="submit">Update</button>
    </form>


    <section>
        <div class="w-1/2 bg-white rounded-xl p-3.5 mb-5">
            <form method="GET" action="{{ route('audit-organizations.index') }}" class="mb-0">

                <div class="relative">
                    <input
                        class="w-full pr-24 placeholder:text-sm border-gray-300/50 border text-gray-900 text-sm rounded-lg focus:ring-[#13A2AF]/30 focus:border-[#13A2AF]/30 p-2.5 outline-none"
                        type="text" name="query" value="{{ request()->query('query') }}"
                        placeholder="Введите название или ИНН">

                    <div
                        class="flex gap-2 absolute right-1.5 text-sm top-1/2 -translate-y-1/2 text-white">

                        <div class="bg-[#13A2AF] p-1 rounded-lg h-7 w-7">
                            <button
                                type="submit">
                                <svg class="stroke-[1.5] h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                     width="24"
                                     height="24"
                                     viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="m21 21-4.3-4.3"/>
                                </svg>
                            </button>
                        </div>
                        <div class="text-[#13A2AF] p-1 h-7 w-7">
                            <a href="{{ route('audit-organizations.index') }}">
                                <svg class="stroke-[1.5] h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 6 6 18"></path>
                                    <path d="m6 6 12 12"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="">

            <div class="flex items-center mb-4">
                <a href="{{ url()->previous() }}"
                   class="flex items-center justify-center rounded-full border border-[#13A2AF] text-[#13A2AF] p-1 pr-2 mr-3 text-sm">
                    <svg class="w-5 h-5 stroke-2 text-[#13A2AF]" xmlns="http://www.w3.org/2000/svg" width="24"
                         height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    Назад к списку
                </a>
                <h2 class="mb-0">{{ $register->name }}</h2>

            </div>


            <div class="flex justify-between gap-4 mb-4">
                <div class="w-full bg-white rounded-xl p-5 flex flex-col gap-3.5">
                    <div class="flex justify-between items-center border-b border-gray-300/50 pb-3">

                        <a class="flex gap-1 items-center text-[#004e88] rounded-full px-3 py-1 text-sm font-semibold bg-[#004e88]/10 hover:ring-2 hover:outline-none hover:ring-[#0069e7]/30"
                           target="_blank"
                           href="https://sroaas.ru/firms/{{$register->ornz}}/?tab=tab1">
                            <img class="w-4 h-4" src="{{ asset('public/images/icon-aac.png') }}" alt="">
                            <span>Данные из реестра ААС</span>
                        </a>

                        <div class="text-sm">
                            @if($register->aac_is_active)
                                <span
                                    class="text-green-500">Действующая</span>
                            @elseif($register->aac_is_suspended)
                                <span
                                    class="text-amber-500">Приостановлено членство</span>
                            @elseif($register->aac_is_not_registry)
                                <span
                                    class="text-red-500">Нет в реестре</span>
                            @elseif($register->aac_is_excluded)
                                <span
                                    class="text-red-500">Исключена</span>
                            @endif
                        </div>

                    </div>

                    <div class="">
                        <div class="text-sm text-gray-400">

                            <div class="flex justify-between items-center">
                                <div>Количество аудиторов</div>


                                @if($register->employees_count)
                                    <button data-modal-target="modal-auditors" data-modal-toggle="modal-auditors"
                                            class="text-[#004e88] bg-[#004e88]/10 px-2 py-0.5 rounded-full text-[0.7rem]">
                                        Показать аудиторов
                                    </button>
                                @endif


                            </div>

                        </div>

                        @if($register->employees_count)
                            <div class="">{{ $register->employees_count }}</div>
                        @else
                            <div class="">Нет данных</div>
                        @endif

                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">ОРНЗ</div>
                        @if($register->ornz)
                            <div class="">{{ $register->ornz }}</div>
                        @else
                            <div class="">Нет данных</div>
                        @endif

                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">Дата записи</div>
                        @if($register->basic_date_entry_into_register)
                            <div class="">{{ $register->basic_date_entry_into_register }}</div>
                        @else
                            <div class="">Нет данных</div>
                        @endif

                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">ИНН</div>
                        <div class="">{{ $register->basic_inn }}</div>
                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">ОГРН</div>
                        @if($register->ogrn)
                            <div class="">{{ $register->ogrn }}</div>
                        @else
                            <div class="">Нет данных</div>
                        @endif

                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">Дата образования</div>
                        @if($register->basic_date_state_registration_entity)
                            <div class="">{{ $register->basic_date_state_registration_entity }}</div>
                        @else
                            <div class="">Нет данных</div>
                        @endif

                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">Субъект РФ</div>
                        @if($register->subject)
                            <div class="">{{ $register->subject }}</div>
                        @else
                            <div class="">Нет данных</div>
                        @endif

                    </div>

                    <div class="">
                        <div class="text-sm text-gray-400">

                            <div class="flex justify-between items-center">
                                <div class="flex-1">Дисциплинарное воздействие</div>
                                <button data-modal-target="modal-information-application-disciplinary-measures"
                                        data-modal-toggle="modal-information-application-disciplinary-measures"
                                        class="text-[#004e88] bg-[#004e88]/10 px-2 py-0.5 rounded-full text-[0.7rem]">
                                    Показать нарушения
                                </button>
                            </div>

                        </div>
                        <div class="">
                            @if($register->disciplinary_type_violation)
                                <span class="text-red-500">Есть нарушения</span>
                            @else
                                Нет данных
                            @endif
                        </div>
                    </div>

                    <div class="">
                        <div class="text-sm text-gray-400">

                            <div class="flex justify-between items-center">
                                <div>Сведения об аудиторской деятельности</div>

                                @if(!count($register->auditActivity) == 0)
                                    <button data-modal-target="modal-information-audit-activities"
                                            data-modal-toggle="modal-information-audit-activities"
                                            class="text-[#004e88] bg-[#004e88]/10 px-2 py-0.5 rounded-full text-[0.7rem]">
                                        Показать детали
                                    </button>
                                @endif

                            </div>

                        </div>
                        <div class="">Кол-во отчетов - {{  count($register->auditActivity) }}</div>
                    </div>


                    <div class="">
                        <div class="text-sm text-gray-400">
                            <div class="flex justify-between items-center">
                                <div>В плане ВКД</div>
                                <button data-modal-target="modal-story" data-modal-toggle="modal-story"
                                        class="text-[#004e88] bg-[#004e88]/10 px-2 py-0.5 rounded-full text-[0.7rem]">
                                    Показать историю ВКД
                                </button>
                            </div>
                        </div>
                        <div class="">


                            @if($register->plans->isEmpty())
                                <p>Нет данных</p>
                            @else
                                @foreach($register->plans as $plan)
                                    @if(!empty($plan->check_start_dates))
                                        {{ \Carbon\Carbon::parse($plan->check_start_dates)->locale('ru')->isoFormat('D MMMM YYYY') }}
                                    @endif
                                @endforeach
                            @endif

                        </div>
                    </div>

                    <div class="">
                        <div class="text-sm text-gray-400">
                            <div class="flex justify-between items-center">
                                <div>ОЗО</div>
                            </div>
                        </div>

                        <div>
                        <span
                            class="{{ $register->ozo_is_status === null ? 'text-[#384253]' : ($register->ozo_is_status ? 'text-green-500' : 'text-red-500') }}">
                                    {{ $register->ozo_is_status === null ? 'Нет в реестре' : ($register->ozo_is_status ? 'В реестре' : 'Исключен') }}
                                </span>
                        </div>
                    </div>

                    <div class="">

                        <div class="text-sm text-gray-400">
                            <div class="flex justify-between items-center">
                                <div>ОЗОФР</div>
                            </div>
                        </div>

                        <div>
                        <span
                            class="{{ $register->ozofr_is_status === null ? 'text-[#384253]' : ($register->ozofr_is_status ? 'text-green-500' : 'text-red-500') }}">
                                    {{ $register->ozofr_is_status === null ? 'Нет в реестре' : ($register->ozofr_is_status ? 'В реестре' : 'Исключен') }}
                                </span>
                        </div>

                    </div>

                </div>

                <div class="w-full bg-white rounded-xl p-5 flex flex-col gap-3.5">

                    <div class="flex justify-between items-center border-b border-gray-300/50 pb-3">

                        <div class="flex items-center gap-1">
                            <a class="flex gap-1 items-center text-[#23A64C] rounded-full px-3 py-1 text-sm font-semibold bg-[#23A64C]/10 hover:ring-2 hover:outline-none hover:ring-[#23A64C]/30"
                               target="_blank"
                               href="https://focus.kontur.ru/entity?query={{$register->ogrn}}">
                                <img class="w-4 h-4" src="{{ asset('public/images/icon-focus.svg') }}" alt="">
                                <span>Статус в Контур.Фокус</span>
                            </a>

                            <form method="POST"
                                  action="{{ route('audit-organizations.update', ['basic_inn' => $register->basic_inn]) }}">
                                @csrf
                                @method('POST')
                                <button type="submit">
                                    <div class="flex p-1 items-center font-medium text-sm text-gray-500 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-gray-50 focus:z-10">
                                        <svg class="w-4 h-4 stroke-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                                            <path d="M21 3v5h-5"></path>
                                            <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                                            <path d="M8 16H3v5"></path>
                                        </svg>
                                    </div>
                                </button>
                            </form>
                        </div>
                        <div class="text-sm">
                            @if($register->focus_status)
                                <span
                                    class="text-green-500">Действующая</span>
                            @elseif($register->focus_status)
                                <span
                                    class="text-amber-500">Приостановлено членство</span>
                            @elseif($register->focus_status)
                                <span
                                    class="text-red-500">Нет в реестре</span>
                            @elseif($register->focus_status)
                                <span
                                    class="text-red-500">Исключена</span>
                            @endif
                        </div>

                    </div>


                    <div class="">
                        <div class="text-sm text-gray-400">ИНН</div>
                        <div class="">{{ $register->focus_inn ?? 'Нет данных' }}</div>
                    </div>

                    <div class="">
                        <div class="text-sm text-gray-400">ОГРН</div>
                        <div class="">{{ $register->focus_ogrn ?? 'Нет данных' }}</div>
                    </div>

                    <div class="">
                        <div class="text-sm text-gray-400">Субъект РФ</div>
                        <div class="">{{ $register->focus_subject ?? 'Нет данных' }}</div>
                    </div>

                    <div class="">
                        <div class="text-sm text-gray-400">Дата регистрации</div>
                        <div class="">{{ $register->focus_registration_date ?? 'Нет данных' }}</div>
                    </div>

                    <div class="">
                        <div class="text-sm text-gray-400">Дата ликвидации</div>
                        <div class="">{{ $register->focus_dissolution_date ?? 'Нет данных' }}</div>
                    </div>


                    <div class="text-sm text-gray-400">
                        Осталось запросов {{ $stats['limit'] - $stats['spent'] }}
                    </div>
                </div>

                @isset($companies)
                    <div class="w-full bg-white rounded-xl p-5 flex flex-col gap-3.5">
                        <div class="flex justify-between items-center border-b border-gray-300/50 pb-3">

                            <a class="text-[#d81a73] rounded-full px-3 py-1 text-sm font-semibold bg-[#0069e7]/10 hover:ring-2 hover:outline-none hover:ring-[#0069e7]/30"
                               target="_blank"
                               href="https://sckontur.bitrix24.ru/crm/company/details/{{ $companies['ID'] }}/">
                                <span class="text-[#0069e7]">24 СЦ Контур</span>
                            </a>

                            <div class="flex gap-2">
                                <div
                                    class="flex items-center font-medium text-sm text-gray-500 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-gray-50 focus:z-10">
                                    <a class="p-1" href="#" target="_blank">
                                        <svg class="w-4 h-4 stroke-1" xmlns="http://www.w3.org/2000/svg" width="24"
                                             height="24" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/>
                                            <path d="M21 3v5h-5"/>
                                            <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/>
                                            <path d="M8 16H3v5"/>
                                        </svg>
                                    </a>

                                </div>
                                {{--                            <div--}}
                                {{--                                class="flex items-center font-medium text-sm text-gray-500 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-gray-50 focus:z-10">--}}
                                {{--                                <a class="p-1"--}}
                                {{--                                   href="https://sckontur.bitrix24.ru/crm/company/details/{{ $companies['ID'] }}/"--}}
                                {{--                                   target="_blank">--}}
                                {{--                                    <svg class="w-4 h-4 stroke-1" xmlns="http://www.w3.org/2000/svg" width="24"--}}
                                {{--                                         height="24"--}}
                                {{--                                         viewBox="0 0 24 24"--}}
                                {{--                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"--}}
                                {{--                                         stroke-linejoin="round">--}}
                                {{--                                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>--}}
                                {{--                                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>--}}
                                {{--                                    </svg>--}}
                                {{--                                </a>--}}

                                {{--                            </div>--}}
                            </div>
                        </div>

                        <div class="">
                            <div class="text-sm text-gray-400">Тип</div>
                            <div class="">{{ $register->type->type }}</div>
                        </div>
                        {{--                    @dd($companies['DEALS_AUDITXP']['LOSE'])--}}
                        <div class="">
                            <div class="text-sm text-gray-400 mb-2">Сделки AuditXP</div>


                            @if($companies['DEALS_AUDITXP']['LAST_WON'])
                                <div class="flex flex-col gap-3 p-2 text-sm bg-green-50 text-green-600 rounded-md mb-4">

                                    <div class="text-[#384253]">Последняя успешная
                                        сделка: {{ $companies['DEALS_AUDITXP']['LAST_WON']['DATE'] }}, на сумму: <span
                                            class="whitespace-nowrap after:ml-0.5 after:content-['\20BD']">{{ $companies['DEALS_AUDITXP']['LAST_WON']['OPPORTUNITY'] }}</span>,
                                        продукт: {{ $companies['DEALS_AUDITXP']['LAST_WON']['PRODUCT'] }},
                                        источник: {{ $companies['DEALS_AUDITXP']['LAST_WON']['SOURCE'] }} <a
                                            target="_blank"
                                            class="bg-green-200 text-green-600 py-0.5 px-2 text-[0.7rem] rounded-full"
                                            href="https://sckontur.bitrix24.ru/crm/deal/details/{{ $companies['DEALS_AUDITXP']['LAST_WON']['ID'] }}/">Показать</a>
                                    </div>
                                    <div class="">Все успешные
                                        сделки: {{ $companies['DEALS_AUDITXP']['WON']['COUNT'] }} сделки на <span
                                            class="whitespace-nowrap after:ml-0.5 after:content-['\20BD']">{{ $companies['DEALS_AUDITXP']['WON']['TOTAL_OPPORTUNITY'] }}</span>

                                    </div>
                                </div>
                            @else
                                <div class="flex flex-col gap-3 p-2 text-sm bg-green-50 text-green-600 rounded-md mb-4">
                                    Нет успешных сделок
                                </div>
                            @endif

                            @if($companies['DEALS_AUDITXP']['LOSE'])
                                <div class="text-sm">
                                    <div class="p-2 text-sm bg-red-50 text-red-500 rounded-md mb-4">
                                        Проваленные: {{ $companies['DEALS_AUDITXP']['LOSE']['COUNT'] }} сделки на <span
                                            class="whitespace-nowrap after:ml-0.5 after:content-['\20BD']">{{ $companies['DEALS_AUDITXP']['LOSE']['TOTAL_OPPORTUNITY'] }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="p-2 text-sm bg-red-50 text-red-500 rounded-md mb-4">
                                    Нет проваленных сделок
                                </div>
                            @endif
                        </div>


                        <div class="">
                            <div class="text-sm text-gray-400 mb-2">Сделки АО Контур</div>
                            <div class="text-sm">


                                @if($companies['DEALS_KONTUR']['LAST_WON'])
                                    <div
                                        class="flex flex-col gap-3 p-2 text-sm bg-green-50 text-green-600 rounded-md mb-4">

                                        <div class="text-[#384253]">Последняя успешная
                                            сделка: {{ $companies['DEALS_KONTUR']['LAST_WON']['DATE'] }}, на сумму:
                                            <span
                                                class="whitespace-nowrap after:ml-0.5 after:content-['\20BD']">{{ $companies['DEALS_KONTUR']['LAST_WON']['OPPORTUNITY'] }}</span>,
                                            продукт: {{ $companies['DEALS_KONTUR']['LAST_WON']['PRODUCT'] }},
                                            источник: {{ $companies['DEALS_KONTUR']['LAST_WON']['SOURCE'] }} <a
                                                target="_blank"
                                                class="bg-green-200 text-green-600 py-0.5 px-2 text-[0.7rem] rounded-full"
                                                href="https://sckontur.bitrix24.ru/crm/deal/details/{{ $companies['DEALS_KONTUR']['LAST_WON']['ID'] }}/">Показать</a>
                                        </div>
                                        <div class="">Все успешные
                                            сделки: {{ $companies['DEALS_KONTUR']['WON']['COUNT'] }} сделки на <span
                                                class="whitespace-nowrap after:ml-0.5 after:content-['\20BD']">{{ $companies['DEALS_KONTUR']['WON']['TOTAL_OPPORTUNITY'] }}</span>

                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="flex flex-col gap-3 p-2 text-sm bg-green-50 text-green-600 rounded-md mb-4">
                                        Нет успешных сделок
                                    </div>
                                @endif

                                @if($companies['DEALS_KONTUR']['LOSE'])
                                    <div class="text-sm">
                                        <div class="p-2 text-sm bg-red-50 text-red-500 rounded-md mb-4">
                                            Проваленные: {{ $companies['DEALS_KONTUR']['LOSE']['COUNT'] }} сделки на
                                            <span
                                                class="whitespace-nowrap after:ml-0.5 after:content-['\20BD']">{{ $companies['DEALS_KONTUR']['LOSE']['TOTAL_OPPORTUNITY'] }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-2 text-sm bg-red-50 text-red-500 rounded-md mb-4">
                                        Нет проваленных сделок
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                @else
                    <div
                        class="flex items-center justify-center w-full bg-white rounded-xl p-5 flex-col gap-3.5 striped-background">
                        <div class="font-bold">
                            Нет данных
                        </div>
                    </div>
                @endisset
            </div>

            <h2>Контакты</h2>
            <div class="flex justify-between gap-4 mb-4">
                <div class="w-full bg-white rounded-xl p-5 flex flex-col gap-3.5">

                    <div class="flex border-b border-gray-300/50 pb-3">
                        <div
                            class="flex gap-1 items-center text-[#004e88] rounded-full px-3 py-1 text-sm font-semibold bg-[#004e88]/10">
                            <img class="w-4 h-4" src="{{ asset('public/images/icon-aac.png') }}" alt="">
                            <span>Из реестра ААС</span>
                        </div>

                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">Руководитель</div>
                        <div class="">
                            @if($register->controls_job_title)
                                <div class="">{{ $register->controls_job_title }}
                                    : {{ $register->controls_surname .' '. $register->controls_name.' '. $register->controls_family }}</div>
                            @else
                                <div class="">Нет данных</div>
                            @endif

                        </div>
                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">Адрес</div>
                        @if($register->contacts_address_executive_body)
                            <div class="">{{ $register->contacts_address_executive_body }}</div>
                        @else
                            <div class="">Нет данных</div>
                        @endif

                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">Телефон</div>
                        @if($register->phones->isEmpty())
                            <div class="">Нет данных</div>
                        @else
                            <div class="">{{ implode(', ', $register->phones->pluck('phone_number')->toArray()) }}</div>
                        @endif

                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">Сайт</div>
                        @if($register->contacts_site)
                            <a class="text-[#13A2AF]" href="http://{{ $register->contacts_site }}" target="_blank">{{ $register->contacts_site }}</a>
                        @else
                            <div class="">Нет данных</div>
                        @endif

                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">E-mail</div>
                        @if($register->contacts_email)
                            <div class="">{{ $register->contacts_email }}</div>
                        @else
                            <div class="">Нет данных</div>
                        @endif


                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">ОРНЗ</div>
                        @if($register->controls_ornz)
                            <div class="">{{ $register->controls_ornz }}</div>
                        @else
                            <div class="">Нет данных</div>
                        @endif

                    </div>

                </div>
                <div class="w-full bg-white rounded-xl p-5 flex flex-col gap-3.5">
                    <div class="flex border-b border-gray-300/50 pb-3">
                        <div
                            class="flex gap-1 items-center text-[#23A64C] rounded-full px-3 py-1 text-sm font-semibold bg-[#23A64C]/10">
                            <img class="w-4 h-4" src="{{ asset('public/images/icon-focus.svg') }}" alt="">
                            <span>Из Контур.Фокус</span>
                        </div>
                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">Руководитель</div>
                        <div class="">{{ $register->focus_head ?? 'Нет данных' }}</div>
                    </div>
                    <div class="">
                        <div class="text-sm text-gray-400">Адрес</div>
                        <div class="">{{ $register->focus_address ?? 'Нет данных' }}</div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- Main modal -->
    <div id="modal-story" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        История ВКД
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="modal-story">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    @foreach($register->inspections as $inspection)

                        <div class="flex flex-col gap-2 border-b py-5 last:border-b-0">
                            <div class="">
                                <div class="text-sm text-gray-400">Дата проведения проверки</div>
                                <div class="">{{ $inspection->dates_of_inspection }}</div>
                            </div>
                            <div class="">
                                <div class="text-sm text-gray-400">Наименование организации</div>
                                <div class="">{{ $inspection->inspecting_organ }}</div>
                            </div>
                        </div>

                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <div id="modal-auditors" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Все аудиторы
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="modal-auditors">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    @foreach($register->auditors as $auditor)

                        <div class="flex justify-between gap-2 border-b py-5 last:border-b-0">
                            <div class="">
                                <div class="text-sm text-gray-400">ФИО</div>
                                <div class="">{{ $auditor->auditor_fio }}</div>
                            </div>
                            <div class="">
                                <div class="text-sm text-gray-400">ОРНЗ</div>
                                <div class="">{{ $auditor->auditor_ornz }}</div>
                            </div>
                        </div>

                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <div id="modal-information-application-disciplinary-measures" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Сведения о применении мер дисциплинарного воздействия
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="modal-information-application-disciplinary-measures">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <div class="flex flex-col gap-2 border-b py-5 last:border-b-0">

                        <div class="">
                            <div class="text-sm text-gray-400">Вид нарушения</div>
                            <div class="">{{ $register->disciplinary_type_violation ?? 'Нет данных' }}</div>
                        </div>

                        <div class="">
                            <div class="text-sm text-gray-400">Меры дисциплинарного воздействия</div>
                            <div class="">{{ $register->disciplinary_disciplinary_measures ?? 'Нет данных' }}</div>
                        </div>

                        <div class="">
                            <div class="text-sm text-gray-400">Орган, принявший решение</div>
                            <div class="">{{ $register->disciplinary_body_that_made_decision ?? 'Нет данных' }}</div>
                        </div>

                        <div class="">
                            <div class="text-sm text-gray-400">Срок приостановления членства (дни)</div>
                            <div
                                class="">{{ $register->disciplinary_membership_suspension_period ?? 'Нет данных' }}</div>
                        </div>

                        <div class="">
                            <div class="text-sm text-gray-400">Дата, с которой восстановлено членство</div>
                            <div
                                class="">{{ $register->disciplinary_date_which_membership_was_reinstated ?? 'Нет данных' }}</div>
                        </div>

                        <div class="">
                            <div class="text-sm text-gray-400">Дата погашения меры</div>
                            <div class="">{{ $register->disciplinary_maturity_date_measure ?? 'Нет данных' }}</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="modal-information-audit-activities" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-xl font-semibold">
                        Сведения об аудиторской деятельности
                    </h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="modal-information-audit-activities">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    @foreach($register->auditActivity as $auditActivity)

                        <div class="flex justify-between gap-2 border-b py-5 last:border-b-0">
                            <div class="">
                                <div class="text-sm text-gray-400">Название отчета</div>
                                <div class="">{{ $auditActivity->report_title }}</div>
                            </div>

                            <div class="">
                                <div class="text-sm text-gray-400">Количество выданных заключений</div>
                                <div class="">{{ $auditActivity->number_conclusions }}</div>
                            </div>
                        </div>

                    @endforeach

                </div>

            </div>
        </div>
    </div>
@endsection
