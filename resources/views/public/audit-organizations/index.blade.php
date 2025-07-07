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
    {{--@dd($registers)--}}
    <section>

        <div class="flex items-center justify-between">
            <div class="bg-white rounded-xl p-3.5 mb-5 w-1/2">
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

            <div class="flex gap-4 bg-white rounded-xl p-3.5 mb-5">
                <form action="{{ route('import-plan') }}" method="POST" enctype="multipart/form-data" class="mb-0">
                    @csrf

                    <div class="w-full flex justify-between bg-white rounded-md overflow-hidden border border-gray-200">
                        <input type="file" name="file">
                        <button type="submit"
                                class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium px-5 text-center inline-flex items-center">
                            Импорт
                        </button>
                    </div>
                </form>
                <a class="flex items-center px-4 py-2 font-medium text-sm text-gray-500 border border-gray-200 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-gray-50 focus:z-10"
                   href="{{ route('audit-organizations.parser') }}">

                    <svg class="h-4 w-4 me-2 text-gray-700" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                        <path d="M21 3v5h-5"></path>
                        <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                        <path d="M8 16H3v5"></path>

                    </svg>
                    Обновить данные
                </a>
            </div>

        </div>

        <div class="flex justify-between mb-4">
            <h2>Реестр организаций</h2>

        </div>
        {{--        @dump(old('bitrix24_company_type_id'))--}}


        <x-form.table-wrapper>
            <div class="overflow-auto" id="draggable-table">
                <x-form.table class="min-w-full">
                <thead>


                <tr class="border-b">

                    <x-table.th scope="col" class="flex justify-between items-center">Наименование организации

                        <div class="flex gap-2">
                            <a class="text-gray-500 border border-gray-200 rounded-md hover:bg-gray-50 p-1"
                               href="{{
                                url('/export-filter?' . http_build_query([
                                    'query'                       => request('query'),
                                    'bitrix24_company_type_id'    => is_array(request('bitrix24_company_type_id')) ? implode(',', request('bitrix24_company_type_id')) : request('bitrix24_company_type_id'),
                                    'aac_is_not_registry'         => request('aac_is_not_registry'),
                                    'aac_is_active'               => request('aac_is_active'),
                                    'aac_is_suspended'            => request('aac_is_suspended'),
                                    'aac_is_excluded'             => request('aac_is_excluded'),
                                    'ozo_is_status'               => request('ozo_is_status'),
                                    'ozofr_is_status'             => request('ozofr_is_status'),
                                    'from_date'                   => request('from_date'),
                                    'to_date'                     => request('to_date'),
                                    'from_date_recording'         => request('from_date_recording'),
                                    'to_date_recording'           => request('to_date_recording')
                                ]))
                            }}"
                            >

                                <svg class="w-4 h-4 stroke-1" xmlns="http://www.w3.org/2000/svg" width="24"
                                     height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="M12 2v8"></path>
                                    <path d="m16 6-4 4-4-4"></path>
                                    <rect width="20" height="8" x="2" y="14" rx="2"></rect>
                                    <path d="M6 18h.01"></path>
                                    <path d="M10 18h.01"></path>

                                </svg>
                            </a>

                            <button id="open-filter"
                                    class="text-gray-500 border border-gray-200 rounded-md hover:bg-gray-50 p-1">

                                <svg class="w-4 h-4 stroke-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                                </svg>

                            </button>
                        </div>
                    </x-table.th>
                    <x-table.th scope="col">ИНН</x-table.th>
                    <x-table.th scope="col">Статус ААС</x-table.th>
                    <x-table.th scope="col">Нарушения</x-table.th>
                    <x-table.th scope="col">В плане ВКД</x-table.th>
                    <x-table.th scope="col">Дата записи</x-table.th>
                    <x-table.th scope="col">Тип</x-table.th>
                    <x-table.th scope="col">ОЗО</x-table.th>
                    <x-table.th scope="col">ОЗОФР</x-table.th>
                    <x-table.th scope="col">Кол-во аудиторов</x-table.th>
                    <x-table.th scope="col">Пройдено ВКД</x-table.th>
                    <x-table.th scope="col">Выдано заключений</x-table.th>
                    <x-table.th scope="col">Прирост выданных заключений</x-table.th>


                </tr>


                </thead>

                <tbody>
                @if($registers->isEmpty())
                    <tr id="form-filter"
                        class="border-b border-gray-300/50 last:border-none hidden">
                        <form method="GET" action="{{ route('audit-organizations.index') }}">

                            <x-table.td colspan="2" class="align-top">
                                <div
                                        class="flex flex-col justify-center w-full h-36 overflow-y-auto overflow-x-hidden p-0.5">


                                    <div class="flex items-center gap-3">
                                        <button
                                                class="flex items-center px-4 py-2 text-sm text-[#13A2AF] bg-[#13A2AF]/10 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-[#13A2AF]/20 focus:z-10"
                                                type="submit">
                                            Показать
                                        </button>
                                        <a href="{{ route('audit-organizations.index') }}"
                                           class="text-sm text-[#13A2AF] border-b">
                                            Сбросить
                                        </a>
                                    </div>
                                </div>
                            </x-table.td>


                            <x-table.td class="align-top">


                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">

                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input type="checkbox" id="aac_is_active" name="aac_is_active" value="1"
                                               {{ $aacIsActive ? 'checked' : '' }} class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 rounded focus:ring-0 focus:outline">
                                        <label for="aac_is_active"
                                               class="ms-2 text-sm text-gray-500 w-full">Действующие</label>

                                    </div>

                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input type="checkbox" id="aac_is_suspended" name="aac_is_suspended" value="1"
                                               {{ $aacIsSuspended ? 'checked' : '' }} class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 rounded focus:ring-0 focus:outline">
                                        <label for="aac_is_suspended" class="ms-2 text-sm text-gray-500 w-full">Приостановлено
                                            членство</label>

                                    </div>

                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input type="checkbox" id="aac_is_excluded" name="aac_is_excluded" value="1"
                                               {{ $aacIsExcluded ? 'checked' : '' }} class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 rounded focus:ring-0 focus:outline">
                                        <label for="aac_is_excluded"
                                               class="ms-2 text-sm text-gray-500 w-full">Исключены</label>

                                    </div>

                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input type="checkbox" id="aac_is_not_registry" name="aac_is_not_registry"
                                               value="1"
                                               {{ $aacIsNotRegistry ? 'checked' : '' }} class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 rounded focus:ring-0 focus:outline">
                                        <label for="aac_is_not_registry" class="ms-2 text-sm text-gray-500 w-full">Нет в
                                            реестре</label>

                                    </div>

                                </div>

                            </x-table.td>


                            <x-table.td class="align-top">

                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input type="checkbox" id="violationExists" name="violationExists" value="1"
                                               {{ $violationExists ? 'checked' : '' }} class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 rounded focus:ring-0 focus:outline">
                                        <label for="violationExists" class="ms-2 text-sm text-gray-500">Есть
                                            нарушения</label>

                                    </div>
                                </div>
                            </x-table.td>

                            <x-table.td class="align-top">
                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">
                                    <div class="flex flex-col gap-2 p-2">

                                        <div class="flex items-center bg-white rounded-md">
                                            <div class="text-gray-500 text-sm pl-1.5">от</div>

                                            <input
                                                    class="placeholder:text-sm text-gray-500 text-sm focus:ring-0 border-none bg-white p-1.5 outline-none rounded-md w-full"
                                                    type="date" name="from_date"
                                                    value="{{ request()->query('from_date') }}">

                                        </div>

                                        <div class="flex items-center bg-white rounded-md">

                                            <div class="text-gray-500 text-sm pl-1.5">до</div>

                                            <input
                                                    class="placeholder:text-sm text-gray-500 text-sm focus:ring-0 border-none p-1.5 outline-none w-full"
                                                    type="date" name="to_date"
                                                    value="{{ request()->query('to_date') }}">
                                        </div>
                                    </div>
                                </div>
                            </x-table.td>


                            <x-table.td class="align-top">
                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">


                                    @foreach($companyTypes as $type)
                                        <div class="flex items-center p-2 hover:bg-gray-200">
                                            <input id="checkbox-item-{{ $type->id }}" type="checkbox"
                                                   name="bitrix24_company_type_id[]" value="{{ $type->id }}"
                                                   {{ is_array(old('bitrix24_company_type_id')) && in_array($type->id, old('bitrix24_company_type_id')) ? 'checked' : '' }} class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 rounded focus:ring-0 focus:outline">
                                            <label for="checkbox-item-{{ $type->id }}"
                                                   class="ms-2 text-sm text-gray-500">{{ $type->type }}</label>
                                        </div>
                                    @endforeach


                                </div>

                            </x-table.td>

                            <x-table.td class="align-top">


                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input id="ozo_is_status-1" type="radio" value="" name="ozo_is_status"
                                               class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 focus:ring-0"
                                                {{ $ozoIsStatus === null ? 'checked' : '' }}>
                                        <label for="ozo_is_status-1" class="ms-2 text-sm text-gray-500">Не
                                            выбрано</label>
                                    </div>
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input id="ozo_is_status-2" type="radio" value="1" name="ozo_is_status"
                                               class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 focus:ring-0"
                                                {{ $ozoIsStatus === true ? 'checked' : '' }}>
                                        <label for="ozo_is_status-2" class="ms-2 text-sm text-gray-500">В
                                            реестре</label>
                                    </div>
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input id="ozo_is_status-3" type="radio" value="0" name="ozo_is_status"
                                               class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 focus:ring-0"
                                                {{ $ozoIsStatus === false ? 'checked' : '' }}>
                                        <label for="ozo_is_status-3" class="ms-2 text-sm text-gray-500">Исключен</label>
                                    </div>
                                </div>


                            </x-table.td>

                            <x-table.td class="align-top">

                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input id="ozofr_is_status-1" type="radio" value="" name="ozofr_is_status"
                                               class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 focus:ring-0"
                                                {{ $ozofrIsStatus === null ? 'checked' : '' }}>
                                        <label for="ozofr_is_status-1" class="ms-2 text-sm text-gray-500">Не
                                            выбрано</label>
                                    </div>
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input id="ozofr_is_status-2" type="radio" value="1" name="ozofr_is_status"
                                               class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 focus:ring-0"
                                                {{ $ozofrIsStatus === true ? 'checked' : '' }}>
                                        <label for="ozofr_is_status-2" class="ms-2 text-sm text-gray-500">В
                                            реестре</label>
                                    </div>
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input id="ozofr_is_status-3" type="radio" value="0" name="ozofr_is_status"
                                               class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 focus:ring-0"
                                                {{ $ozofrIsStatus === false ? 'checked' : '' }}>
                                        <label for="ozofr_is_status-3"
                                               class="ms-2 text-sm text-gray-500">Исключен</label>
                                    </div>
                                </div>


                            </x-table.td>
                        </form>
                    </tr>
                    <x-table.td class="align-top px-0">
                        По вашему запросу ничего не найдено
                    </x-table.td>
                @else
                    <tr id="form-filter"
                        class="border-b border-gray-300/50 last:border-none hidden">
                        <form method="GET" action="{{ route('audit-organizations.index') }}">

                            <x-table.td colspan="2" class="align-top">
                                <div
                                        class="flex flex-col justify-center w-full h-36 overflow-y-auto overflow-x-hidden p-0.5">


                                    <div class="flex items-center gap-3">
                                        <button
                                                class="flex items-center px-4 py-2 text-sm text-[#13A2AF] bg-[#13A2AF]/10 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-[#13A2AF]/20 focus:z-10"
                                                type="submit">
                                            Показать
                                        </button>
                                        <a href="{{ route('audit-organizations.index') }}"
                                           class="text-sm text-[#13A2AF] border-b">
                                            Сбросить
                                        </a>
                                    </div>
                                </div>
                            </x-table.td>


                            <x-table.td class="align-top">


                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">

                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input type="checkbox" id="aac_is_active" name="aac_is_active" value="1"
                                               {{ $aacIsActive ? 'checked' : '' }} class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 rounded focus:ring-0 focus:outline">
                                        <label for="aac_is_active"
                                               class="ms-2 text-sm text-gray-500 w-full">Действующие</label>

                                    </div>

                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input type="checkbox" id="aac_is_suspended" name="aac_is_suspended" value="1"
                                               {{ $aacIsSuspended ? 'checked' : '' }} class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 rounded focus:ring-0 focus:outline">
                                        <label for="aac_is_suspended" class="ms-2 text-sm text-gray-500 w-full">Приостановлено
                                            членство</label>

                                    </div>

                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input type="checkbox" id="aac_is_excluded" name="aac_is_excluded" value="1"
                                               {{ $aacIsExcluded ? 'checked' : '' }} class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 rounded focus:ring-0 focus:outline">
                                        <label for="aac_is_excluded"
                                               class="ms-2 text-sm text-gray-500 w-full">Исключены</label>

                                    </div>

                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input type="checkbox" id="aac_is_not_registry" name="aac_is_not_registry"
                                               value="1"
                                               {{ $aacIsNotRegistry ? 'checked' : '' }} class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 rounded focus:ring-0 focus:outline">
                                        <label for="aac_is_not_registry" class="ms-2 text-sm text-gray-500 w-full">Нет в
                                            реестре</label>

                                    </div>

                                </div>

                            </x-table.td>


                            <x-table.td class="align-top">

                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input type="checkbox" id="violationExists" name="violationExists" value="1"
                                               {{ $violationExists ? 'checked' : '' }} class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 rounded focus:ring-0 focus:outline">
                                        <label for="violationExists" class="ms-2 text-sm text-gray-500">Есть
                                            нарушения</label>

                                    </div>
                                </div>
                            </x-table.td>

                            <x-table.td class="align-top">
                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">
                                    <div class="flex flex-col gap-2 p-2">

                                        <div class="flex items-center bg-white rounded-md">
                                            <div class="text-gray-500 text-sm pl-1.5">от</div>

                                            <input
                                                    class="placeholder:text-sm text-gray-500 text-sm focus:ring-0 border-none bg-white p-1.5 outline-none rounded-md w-full"
                                                    type="date" name="from_date"
                                                    value="{{ request()->query('from_date') }}">

                                        </div>

                                        <div class="flex items-center bg-white rounded-md">

                                            <div class="text-gray-500 text-sm pl-1.5">до</div>

                                            <input
                                                    class="placeholder:text-sm text-gray-500 text-sm focus:ring-0 border-none p-1.5 outline-none w-full"
                                                    type="date" name="to_date"
                                                    value="{{ request()->query('to_date') }}">
                                        </div>
                                    </div>
                                </div>
                            </x-table.td>

                            <x-table.td class="align-top">
                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">
                                    <div class="flex flex-col gap-2 p-2">

                                        <div class="flex items-center bg-white rounded-md">
                                            <div class="text-gray-500 text-sm pl-1.5">от</div>

                                            <input
                                                    class="placeholder:text-sm text-gray-500 text-sm focus:ring-0 border-none bg-white p-1.5 outline-none rounded-md w-full"
                                                    type="date" name="from_date_recording"
                                                    value="{{ request()->query('from_date_recording') }}">

                                        </div>

                                        <div class="flex items-center bg-white rounded-md">

                                            <div class="text-gray-500 text-sm pl-1.5">до</div>

                                            <input
                                                    class="placeholder:text-sm text-gray-500 text-sm focus:ring-0 border-none p-1.5 outline-none w-full"
                                                    type="date" name="to_date_recording"
                                                    value="{{ request()->query('to_date_recording') }}">
                                        </div>
                                    </div>
                                </div>
                            </x-table.td>

                            <x-table.td class="align-top">
                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">


                                    @foreach($companyTypes as $type)
                                        <div class="flex items-center p-2 hover:bg-gray-200">
                                            <input id="checkbox-item-{{ $type->id }}" type="checkbox"
                                                   name="bitrix24_company_type_id[]" value="{{ $type->id }}"
                                                   {{ is_array(old('bitrix24_company_type_id')) && in_array($type->id, old('bitrix24_company_type_id')) ? 'checked' : '' }} class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 rounded focus:ring-0 focus:outline">
                                            <label for="checkbox-item-{{ $type->id }}"
                                                   class="ms-2 text-sm text-gray-500">{{ $type->type }}</label>
                                        </div>
                                    @endforeach


                                </div>

                            </x-table.td>


                            <x-table.td class="align-top">


                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input id="ozo_is_status-1" type="radio" value="" name="ozo_is_status"
                                               class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 focus:ring-0"
                                                {{ $ozoIsStatus === null ? 'checked' : '' }}>
                                        <label for="ozo_is_status-1" class="ms-2 text-sm text-gray-500">Не
                                            выбрано</label>
                                    </div>
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input id="ozo_is_status-2" type="radio" value="1" name="ozo_is_status"
                                               class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 focus:ring-0"
                                                {{ $ozoIsStatus === true ? 'checked' : '' }}>
                                        <label for="ozo_is_status-2" class="ms-2 text-sm text-gray-500">В
                                            реестре</label>
                                    </div>
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input id="ozo_is_status-3" type="radio" value="0" name="ozo_is_status"
                                               class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 focus:ring-0"
                                                {{ $ozoIsStatus === false ? 'checked' : '' }}>
                                        <label for="ozo_is_status-3" class="ms-2 text-sm text-gray-500">Исключен</label>
                                    </div>
                                </div>


                            </x-table.td>

                            <x-table.td class="align-top">

                                <div class="w-full h-36 overflow-y-auto overflow-x-hidden bg-[#f1f5f9] rounded-lg">
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input id="ozofr_is_status-1" type="radio" value="" name="ozofr_is_status"
                                               class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 focus:ring-0"
                                                {{ $ozofrIsStatus === null ? 'checked' : '' }}>
                                        <label for="ozofr_is_status-1" class="ms-2 text-sm text-gray-500">Не
                                            выбрано</label>
                                    </div>
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input id="ozofr_is_status-2" type="radio" value="1" name="ozofr_is_status"
                                               class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 focus:ring-0"
                                                {{ $ozofrIsStatus === true ? 'checked' : '' }}>
                                        <label for="ozofr_is_status-2" class="ms-2 text-sm text-gray-500">В
                                            реестре</label>
                                    </div>
                                    <div class="flex items-center p-2 hover:bg-gray-200">
                                        <input id="ozofr_is_status-3" type="radio" value="0" name="ozofr_is_status"
                                               class="w-4 h-4 text-[#13A2AF] bg-white border-gray-300 focus:ring-0"
                                                {{ $ozofrIsStatus === false ? 'checked' : '' }}>
                                        <label for="ozofr_is_status-3"
                                               class="ms-2 text-sm text-gray-500">Исключен</label>
                                    </div>
                                </div>


                            </x-table.td>
                        </form>
                    </tr>
                    @foreach($registers as $registry)
                        <tr class="border-b border-gray-300/50 hover:bg-[#13A2AF]/10 last:border-none">
                            <x-table.td>
                                <a class="text-[#13A2AF]"
                                   href="{{ route('audit-organizations.show', $registry->basic_inn) }}">

                                    <div>
                                        {{ $registry->name }}
                                    </div>


                                </a>
                            </x-table.td>


                            <x-table.td>{{ $registry->basic_inn }}</x-table.td>

                            <x-table.td>


                                @if($registry->aac_is_active)
                                    <span
                                            class="text-green-500">Действующая</span>
                                @elseif($registry->aac_is_suspended)
                                    <span
                                            class="text-amber-500">Приостановлено членство</span>
                                @elseif($registry->aac_is_not_registry)
                                    <span
                                            class="text-red-500">Нет в реестре</span>
                                @elseif($registry->aac_is_excluded)
                                    <span
                                            class="text-red-500">Исключена</span>
                                @endif

                            </x-table.td>

                            <x-table.td class="text-sm text-gray-400">
                                @if($registry->disciplinary_type_violation)
                                    <span
                                            class="bg-red-500/10 text-red-500 px-2 py-0.5 rounded-full">Есть нарушения</span>
                                @else
                                    Нет данных
                                @endif
                            </x-table.td>
                            <x-table.td class="text-gray-400">

                                @if(!empty($registry->plans[0]->check_start_dates))
                                    @foreach($registry->plans as $plan)
                                        @if(!empty($plan->check_start_dates))
                                            <span
                                                    class="text-amber-600">
                                            {{ \Carbon\Carbon::parse($plan->check_start_dates)->locale('ru')->isoFormat('D MMMM YYYY') }}
                                            </span>
                                        @endif
                                    @endforeach
                                @else
                                    Нет данных
                                @endif

                            </x-table.td>

                            <x-table.td class="text-gray-400">


                                @if(!empty($registry->basic_date_entry_into_register))
                                    <span
                                            class="text-amber-600">
                                    {{ \Carbon\Carbon::parse($registry->basic_date_entry_into_register)->locale('ru')->isoFormat('D MMMM YYYY') }}
                                    </span>
                                @else
                                    Нет данных
                                @endif


                            </x-table.td>

                            <x-table.td>
                                <div class="text-gray-500">
                                    {{ $registry->type->type ?? '' }}
                                </div>
                            </x-table.td>

                            <x-table.td class="text-sm text-gray-400">

                                <span
                                        class="{{ $registry->ozo_is_status === null ? 'text-gray-400' : ($registry->ozo_is_status ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500') }} px-2 py-0.5 rounded-full">
                                    {{ $registry->ozo_is_status === null ? 'Нет в реестре' : ($registry->ozo_is_status ? 'В реестре' : 'Исключен') }}
                                </span>

                            </x-table.td>

                            <x-table.td>

                                 <span
                                         class="{{ $registry->ozofr_is_status === null ? 'text-gray-400' : ($registry->ozofr_is_status ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500') }} px-2 py-0.5 rounded-full">
                                    {{ $registry->ozofr_is_status === null ? 'Нет в реестре' : ($registry->ozofr_is_status ? 'В реестре' : 'Исключен') }}
                                </span>


                            </x-table.td>

                            <x-table.td>
                                {!! $registry->employees_count ? : '<div class="text-gray-400">Нет данных</div>' !!}
                            </x-table.td>

                            <x-table.td>
                                {!! count($registry->inspections) > 0 ? count($registry->inspections) : '<div class="text-gray-400">Нет данных</div>' !!}
                            </x-table.td>

                            <x-table.td>
                                @php
                                    $firstNumberConclusion = $registry->auditActivity->first()->number_conclusions ?? null;

                                @endphp
                                {!! $firstNumberConclusion ?? '<div class="text-gray-400">Нет данных</div>' !!}
                            </x-table.td>

                            <x-table.td>
                                @php

                                    $secondNumberConclusion = $registry->auditActivity->skip(1)->first()->number_conclusions ?? null;
                                @endphp

                                @if(is_numeric($firstNumberConclusion) && is_numeric($secondNumberConclusion) && $secondNumberConclusion != 0)


                                    @php
                                        $res = round((($firstNumberConclusion - $secondNumberConclusion) / $secondNumberConclusion) * 100, 2);
                                    @endphp

                                    <div class="">
                                        {{ $firstNumberConclusion - $secondNumberConclusion }}
                                        <sup class="{{ $res < 0 ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $res }}%
                                        </sup>
                                    </div>

                                @else
                                    <div class="text-gray-400">Нет данных</div>
                                @endif
                            </x-table.td>



                        </tr>
                    @endforeach
                @endif
                </tbody>
            </x-form.table>
            </div>
        </x-form.table-wrapper>

        {{ $registers->withQueryString() }}
    </section>

@endsection


<script>
    window.onload = function(){
        var container = document.getElementById('draggable-table'),
            isMouseDown = false,
            startPos = {};

        container.addEventListener('mousedown', function(e){
            isMouseDown = true;
            startPos.x = e.pageX;
            startPos.scrollLeft = container.scrollLeft;
        });

        container.addEventListener('mousemove', function(e){
            if (!isMouseDown) {
                return;
            }
            container.scrollLeft = startPos.scrollLeft + (startPos.x - e.pageX);
        });

        container.addEventListener('mouseup', function(){
            isMouseDown = false;
        });

        container.addEventListener('mouseleave', function(){
            isMouseDown = false;
        });
    };

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('open-filter').addEventListener('click', function () {
            const formFilterBlock = document.getElementById('form-filter');
            if (formFilterBlock.style.display === 'none' || formFilterBlock.style.display === '') {
                formFilterBlock.style.display = 'table-row';
            } else {
                formFilterBlock.style.display = 'none';
            }
        });
    });
</script>
