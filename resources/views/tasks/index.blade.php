<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой TO-DO список</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen py-8">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Мои задачи</h1>

        <!-- Форма добавления новой задачи -->
        <form action="{{ route('tasks.store') }}" method="POST" class="mb-6">
            @csrf
            <div class="flex gap-2">
                <input
                    type="text"
                    name="title"
                    placeholder="Введите новую задачу..."
                    required
                    class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
                >
                    Добавить
                </button>
            </div>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </form>

        <!-- Список задач -->
        @if($tasks->count())
            <ul class="space-y-3">
                @foreach($tasks as $task)
                    <li class="flex items-center justify-between p-3 border border-gray-200 rounded hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input
                                    type="checkbox"
                                    onchange="this.form.submit()"
                                    {{ $task->completed ? 'checked' : '' }}
                                    class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500"
                                >
                            </form>
                            <span class="{{ $task->completed ? 'line-through text-gray-500' : 'text-gray-800' }}">
                                {{ $task->title }}
                            </span>
                        </div>

                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                onclick="return confirm('Удалить задачу?')"
                                class="text-red-500 hover:text-red-700"
                            >
                                Удалить
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 text-center mt-6">Список задач пуст. Добавьте первую!</p>
        @endif
    </div>
</body>
</html>