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

        <h1>Продукты</h1>

        <x-form.table-wrapper>
            <form action="{{ route('managers.store') }}" method="post">
                @csrf
                <div class="flex gap-3 mb-4">


                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ФИО</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="border-gray-300/50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-[#13A2AF]/30 focus:border-[#13A2AF]/30 block w-full p-2.5 outline-none"/>
                        @error('name')
                        <div class="text-xs text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="id_billing" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID менеджера в биллинг</label>
                        <input type="text" id="id_billing" name="id_billing" value="{{ old('id_billing') }}" class="border-gray-300/50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-[#13A2AF]/30 focus:border-[#13A2AF]/30 block w-full p-2.5 outline-none"/>
                        @error('id_billing')
                        <div class="text-xs text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="id_crm" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID менеджера в crm</label>
                        <input type="text" id="id_crm" name="id_crm" value="{{ old('id_crm') }}" class="border-gray-300/50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-[#13A2AF]/30 focus:border-[#13A2AF]/30 block w-full p-2.5 outline-none"/>
                        @error('id_crm')
                        <div class="text-xs text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <button type="submit" class="flex items-center px-4 py-2 font-medium text-sm text-[#13A2AF] bg-[#13A2AF]/10 rounded-lg focus:ring-2 focus:outline-none focus:ring-[#13A2AF]/30 hover:bg-[#13A2AF]/20 focus:z-10">
                    Сохранить
                </button>
            </form>
        </x-form.table-wrapper>
    </section>

@endsection
