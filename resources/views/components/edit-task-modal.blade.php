@props(['task'])

<div id="editTaskModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- Modal container -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="editTaskForm">
                @csrf
                @method('PATCH')
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Редактировать задачу
                            </h3>
                            
                            <div class="mt-4 w-full">
                                <label for="editTitle" class="block text-sm font-medium text-gray-700">
                                    Название
                                </label>
                                <input
                                    type="text"
                                    id="editTitle"
                                    name="title"
                                    value="{{ $task->title }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required
                                >
                            </div>
                            
                            <div class="mt-4 w-full">
                                <label for="editDescription" class="block text-sm font-medium text-gray-700">
                                    Описание
                                </label>
                                <textarea
                                    id="editDescription"
                                    name="description"
                                    rows="3"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                >{{ $task->description }}</textarea>
                            </div>
                            
                            <div class="mt-4 flex items-center">
                                <input
                                    type="checkbox"
                                    id="editCompleted"
                                    name="completed"
                                    {{ $task->completed ? 'checked' : '' }}
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                >
                                <label for="editCompleted" class="ml-2 block text-sm text-gray-900">
                                    Завершено
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button
                        type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Сохранить
                    </button>
                    <button
                        type="button"
                        id="cancelEdit"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Отмена
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>