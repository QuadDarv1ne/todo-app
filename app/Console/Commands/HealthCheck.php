<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Task;

/**
 * Команда для проверки здоровья приложения
 * 
 * Использование:
 * php artisan app:health-check
 */
class HealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:health-check {--fix : Попытаться исправить найденные проблемы}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проверка здоровья приложения и конфигурации';

    /**
     * Счётчик проблем
     *
     * @var int
     */
    private $issues = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏥 Проверка здоровья приложения...');
        $this->newLine();

        $this->checkDatabase();
        $this->checkCache();
        $this->checkEnvironment();
        $this->checkVapidKeys();
        $this->checkSanctum();
        $this->checkStorage();
        $this->checkData();

        $this->newLine();
        
        if ($this->issues === 0) {
            $this->info('✅ Все проверки пройдены успешно!');
            return 0;
        } else {
            $this->error("❌ Найдено проблем: {$this->issues}");
            
            if (!$this->option('fix')) {
                $this->newLine();
                $this->info('💡 Совет: Запустите команду с флагом --fix для автоматического исправления проблем');
                $this->line('   php artisan app:health-check --fix');
            }
            
            return 1;
        }
    }

    /**
     * Проверка подключения к базе данных
     */
    private function checkDatabase(): void
    {
        $this->info('🗄️  Проверка базы данных...');
        
        try {
            DB::connection()->getPdo();
            $this->line('  ✓ Подключение к БД: OK');
            
            // Проверка таблиц
            $tables = ['users', 'tasks', 'tags', 'achievements'];
            foreach ($tables as $table) {
                if (DB::getSchemaBuilder()->hasTable($table)) {
                    $this->line("  ✓ Таблица {$table}: существует");
                } else {
                    $this->error("  ✗ Таблица {$table}: не найдена");
                    $this->issues++;
                    
                    if ($this->option('fix')) {
                        $this->warn("  → Запустите миграции: php artisan migrate");
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error('  ✗ Ошибка подключения к БД: ' . $e->getMessage());
            $this->issues++;
        }
        
        $this->newLine();
    }

    /**
     * Проверка кэша
     */
    private function checkCache(): void
    {
        $this->info('💾 Проверка кэша...');
        
        try {
            Cache::put('health_check_test', 'ok', 10);
            $value = Cache::get('health_check_test');
            
            if ($value === 'ok') {
                $this->line('  ✓ Кэш: работает');
                Cache::forget('health_check_test');
            } else {
                $this->error('  ✗ Кэш: не работает корректно');
                $this->issues++;
            }
        } catch (\Exception $e) {
            $this->error('  ✗ Кэш: ошибка - ' . $e->getMessage());
            $this->issues++;
            
            if ($this->option('fix')) {
                $this->call('cache:clear');
                $this->line('  → Кэш очищен');
            }
        }
        
        $this->newLine();
    }

    /**
     * Проверка переменных окружения
     */
    private function checkEnvironment(): void
    {
        $this->info('⚙️  Проверка конфигурации...');
        
        $required = [
            'APP_NAME' => config('app.name'),
            'APP_ENV' => config('app.env'),
            'APP_KEY' => config('app.key'),
            'APP_URL' => config('app.url'),
            'DB_CONNECTION' => config('database.default'),
        ];
        
        foreach ($required as $key => $value) {
            if (!empty($value)) {
                $this->line("  ✓ {$key}: установлен");
            } else {
                $this->error("  ✗ {$key}: не установлен");
                $this->issues++;
            }
        }
        
        // Проверка APP_KEY
        if (empty(config('app.key'))) {
            $this->error('  ✗ APP_KEY не установлен');
            
            if ($this->option('fix')) {
                $this->call('key:generate');
                $this->line('  → APP_KEY сгенерирован');
            }
        }
        
        $this->newLine();
    }

    /**
     * Проверка VAPID ключей для push-уведомлений
     */
    private function checkVapidKeys(): void
    {
        $this->info('🔔 Проверка VAPID ключей (Push-уведомления)...');
        
        $publicKey = config('push.vapid_public_key');
        $privateKey = config('push.vapid_private_key');
        
        if (empty($publicKey) || empty($privateKey)) {
            $this->warn('  ⚠ VAPID ключи не настроены (Push-уведомления отключены)');
            $this->line('  → Это опционально, но рекомендуется для продакшена');
            $this->line('  → Установите: composer require minishlink/web-push');
            $this->line('  → Сгенерируйте: php artisan webpush:vapid');
        } else {
            $this->line('  ✓ VAPID ключи: настроены');
        }
        
        $this->newLine();
    }

    /**
     * Проверка Sanctum
     */
    private function checkSanctum(): void
    {
        $this->info('🔐 Проверка Laravel Sanctum (API токены)...');
        
        if (class_exists(\Laravel\Sanctum\Sanctum::class)) {
            $this->line('  ✓ Sanctum: установлен');
            
            // Проверка таблицы токенов
            if (DB::getSchemaBuilder()->hasTable('personal_access_tokens')) {
                $this->line('  ✓ Таблица токенов: существует');
            } else {
                $this->error('  ✗ Таблица токенов: не найдена');
                $this->issues++;
                
                if ($this->option('fix')) {
                    $this->call('migrate');
                }
            }
        } else {
            $this->warn('  ⚠ Sanctum: не установлен');
            $this->line('  → Установите: composer require laravel/sanctum');
            $this->line('  → Опубликуйте: php artisan vendor:publish --provider="Laravel\\Sanctum\\SanctumServiceProvider"');
        }
        
        $this->newLine();
    }

    /**
     * Проверка директорий хранилища
     */
    private function checkStorage(): void
    {
        $this->info('📁 Проверка директорий хранилища...');
        
        $directories = [
            'storage/app',
            'storage/app/public',
            'storage/framework/cache',
            'storage/framework/sessions',
            'storage/framework/views',
            'storage/logs',
        ];
        
        foreach ($directories as $dir) {
            $path = base_path($dir);
            
            if (is_dir($path)) {
                if (is_writable($path)) {
                    $this->line("  ✓ {$dir}: доступна для записи");
                } else {
                    $this->error("  ✗ {$dir}: нет прав на запись");
                    $this->issues++;
                    
                    if ($this->option('fix') && PHP_OS_FAMILY !== 'Windows') {
                        exec("chmod -R 775 {$path}");
                        $this->line("  → Права установлены");
                    }
                }
            } else {
                $this->error("  ✗ {$dir}: не существует");
                $this->issues++;
                
                if ($this->option('fix')) {
                    mkdir($path, 0775, true);
                    $this->line("  → Директория создана");
                }
            }
        }
        
        // Проверка символической ссылки storage
        if (!is_link(public_path('storage'))) {
            $this->warn('  ⚠ Символическая ссылка storage не создана');
            
            if ($this->option('fix')) {
                $this->call('storage:link');
                $this->line('  → Ссылка создана');
            }
        } else {
            $this->line('  ✓ Символическая ссылка storage: создана');
        }
        
        $this->newLine();
    }

    /**
     * Проверка данных
     */
    private function checkData(): void
    {
        $this->info('📊 Проверка данных...');
        
        // Статистика пользователей
        $usersCount = User::count();
        $this->line("  ℹ Пользователей в БД: {$usersCount}");
        
        if ($usersCount === 0) {
            $this->warn('  ⚠ Нет пользователей в базе данных');
            $this->line('  → Создайте пользователя или запустите сиды: php artisan db:seed');
        }
        
        // Статистика задач
        $tasksCount = Task::count();
        $this->line("  ℹ Задач в БД: {$tasksCount}");
        
        // Статистика завершённых задач
        if ($tasksCount > 0) {
            $completedCount = Task::where('completed', true)->count();
            $completionRate = round(($completedCount / $tasksCount) * 100, 2);
            $this->line("  ℹ Завершённых задач: {$completedCount} ({$completionRate}%)");
        }
        
        $this->newLine();
    }
}
