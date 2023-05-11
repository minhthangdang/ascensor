@extends('layouts.layout')

@section('content')

    <div class="border border-dash border-white p-8 mt-8">
        Click import to import the movies from CSV file.
    </div>

    <form method="post" action="/admin/movies" class="mt-2 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Import
            </button>
        </div>
    </form>
@endsection