@extends('layouts.app')

@section('content')


    <h1>Метки</h1>

    <section>


        <x-form.table-wrapper>
            <x-form.table>
                <thead>
                <tr>
                    <x-table.th scope="col">Метка времени</x-table.th>
                    <x-table.th scope="col">Дата</x-table.th>
                </tr>
                </thead>
                <tbody>
                @foreach($timestamps as $timestamp)
                    <tr class="border-b border-gray-300/50 last:border-none">
                        <x-table.td>{{ $timestamp->timestamp }}</x-table.td>
                        <x-table.td>{{ $timestamp->created_at }}</x-table.td>
                    </tr>
                @endforeach
                </tbody>
            </x-form.table>
        </x-form.table-wrapper>
    </section>
@endsection
