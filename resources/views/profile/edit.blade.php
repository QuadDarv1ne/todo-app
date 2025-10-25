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