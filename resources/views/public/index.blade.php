@extends('layouts.app')

@section('content')
    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file">
        <button type="submit">Импорт</button>
    </form>
@endsection
