<div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
    <a href="{{ url('/') }}" class="flex items-center">
        <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Менеджер задач</span>
    </a>

    <div class="flex items-center lg:order-2">
    @guest
        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Вход
        </a>
        <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
            Регистрация
        </a>
    @else
        <a href="{{ route('logout') }}"
           class="border border-blue-500 text-blue-500 px-4 py-2 rounded hover:bg-blue-500 hover:text-white"
           dusk="logout-button"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Выход') }}
        </a>

        <!-- Скрытая форма для отправки POST-запроса -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endguest
    </div>

    <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1">
        <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
            <li>
                <a href="{{ url('/') }}" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">Задачи</a>
            </li>
            <li>
                <a href="{{ url('/task_statuses') }}" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">Статусы</a>
            </li>
            <li>
                <a href="{{ url('/') }}" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">Метки</a>
            </li>
        </ul>
    </div>
</div>