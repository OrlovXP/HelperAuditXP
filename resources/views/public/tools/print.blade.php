@extends('layouts.app')

@section('content')


    <div class="bg-white rounded-xl p-3.5 mb-5 w-1/2">
        <form method="POST" action="{{ route('deals.print') }}" class="mb-0">
            @csrf
            <div class="relative">
                <input class="w-full pr-24 placeholder:text-sm border-gray-300/50 border text-gray-900 text-sm rounded-lg focus:ring-[#13A2AF]/30 focus:border-[#13A2AF]/30 p-2.5 outline-none" type="text" id="deal-id" name="id" value="{{ request()->input('id') }}" placeholder="Введите ID">

                <div class="flex gap-2 absolute right-1.5 text-sm top-1/2 -translate-y-1/2 text-white">

                    <div class="bg-[#13A2AF] p-1 rounded-lg h-7 w-7">
                        <button type="submit">
                            <svg class="stroke-[1.5] h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>




    @if($data)
        @dump($data)
    @endif


@endsection
