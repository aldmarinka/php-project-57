@extends('layouts.app')

@section('content')
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="grid col-span-full">
            <h2 class="mb-5">Изменение задачи</h2>

            <form class="w-50"  action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="flex flex-col">
                    <div>
                        <label for="name">Имя</label>
                    </div>
                    <div class="mt-2">
                        <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{ $task->name }}">
                    </div>
                    @error('name')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror

                    <div class="mt-2">
                        <label for="description">Описание</label>
                    </div>
                    <div>
                        <textarea class="rounded border-gray-300 w-1/3 h-32" name="description" id="description">{{ $task->description }}</textarea>
                    </div>
                    @error('description')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror

                    <div class="mt-2">
                        <label for="status_id">Статус</label>
                    </div>
                    <div>
                        <select class="rounded border-gray-300 w-1/3" name="status_id" id="status_id">
                            @foreach ($taskStatuses as $status)
                                <option value="{{ $status->id }}" @if($task->status_id == $status->id) selected @endif>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('status_id')
                    <div class="text-rose-600">{{ $message }}</div>
                    @enderror

                    <div class="mt-2">
                        <label for="status_id">Исполнитель</label>
                    </div>
                    <div>
                        <select class="rounded border-gray-300 w-1/3" name="assigned_to_id" id="assigned_to_id">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if($task->assigned_to_id == $user->id) selected @endif>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('assigned_to_id')
                    <div class="text-rose-600">{{ $message }}</div>
                    @enderror

{{--                    <div class="mt-2">--}}
{{--                        <label for="status_id">Метки</label>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <select class="rounded border-gray-300 w-1/3 h-32" name="labels[]" id="labels[]" multiple><option value="1">ошибка</option><option value="2">документация</option><option value="3" selected="selected">дубликат</option><option value="4">доработка</option></select>--}}
{{--                    </div>--}}

                    <div class="mt-2">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Обновить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection