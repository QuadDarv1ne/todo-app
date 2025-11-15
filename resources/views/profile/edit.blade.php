<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Профиль') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information Card -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center">
                            <span class="text-xl font-bold text-indigo-700">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Информация профиля</h3>
                            <p class="text-sm text-gray-600">Управляйте информацией вашего аккаунта</p>
                        </div>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Notifications Card -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-4xl">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Уведомления</h3>
                            <p class="text-sm text-gray-600">Управляйте вашими уведомлениями</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($user->notifications as $notification)
                            <x-notification 
                                :type="$notification->data['type'] === 'task_limit_approaching' ? 'warning' : 'info'"
                                :title="$notification->data['type'] === 'task_limit_approaching' ? 'Предупреждение о лимите задач' : 'Уведомление'"
                                :message="$notification->data['message'] ?? 'Новое уведомление'"
                                :time="$notification->created_at->diffForHumans()"
                                :unread="is_null($notification->read_at)"
                            />
                        @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Нет уведомлений</h3>
                                <p class="mt-1 text-sm text-gray-500">Здесь будут отображаться ваши уведомления.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    @if($user->notifications->count() > 0)
                        <div class="mt-6 flex justify-end">
                            <form method="POST" action="{{ route('profile.notifications.read-all') }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Отметить все как прочитанные
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Password Update Card -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Обновить пароль</h3>
                            <p class="text-sm text-gray-600">Убедитесь, что ваш аккаунт использует надежный пароль</p>
                        </div>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Account Deletion Card -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex-shrink-0 w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Удалить аккаунт</h3>
                            <p class="text-sm text-gray-600">Постоянно удалить ваш аккаунт и все данные</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">
                        После удаления ваша учетная запись и все связанные с ней данные будут безвозвратно удалены. 
                        Перед удалением загрузите любые данные или информацию, которую вы хотите сохранить.
                    </p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>