@extends('layouts.app')

@section('content')
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="grid col-span-full">
            <h1 class="mb-5">Статусы</h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div>
                @auth
                    <div>
                        <a href="{{ route('task_statuses.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Создать статус
                        </a>
                    </div>
                @endauth
            </div>

            <table class="mt-4">
                <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Дата создания</th>
                    @auth
                        <th>Действия</th>
                    @endauth
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($taskStatuses as $status)
                        <tr class="border-b border-dashed text-left">
                            <td>{{ $status->id }}</td>
                            <td>{{ $status->name }}</td>
                            <td>{{ $status->created_at->format('d.m.Y') }}</td>
                            @auth
                            <td>
                                <a href="#" class="text-red-500 hover:text-red-700 ml-2" onclick="event.preventDefault(); if(confirm('Вы уверены, что хотите удалить этот статус?')) { document.getElementById('delete-form-{{ $status->id }}').submit(); }">Удалить</a>
                                <form id="delete-form-{{ $status->id }}" action="{{ route('task_statuses.destroy', $status->id) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a class="text-blue-600 hover:text-blue-900"
                                   href="{{ route('task_statuses.edit', $status->id) }}">
                                    Изменить
                                </a>
                            </td>
                            @endauth

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $taskStatuses->links() }}
            </div>
        </div>
    </div>
@endsection
