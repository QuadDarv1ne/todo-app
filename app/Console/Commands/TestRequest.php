<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;

/**
 * Установка Laravel Sanctum:
 * composer require laravel/sanctum
 * 
 * После установки опубликовать конфигурацию и миграции:
 * php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
 * php artisan migrate
 */

/**
 * ✅ testTasksEndpoints() - полный CRUD для задач
 * ✅ testAuthEndpoints() - проверка аутентификации
 * ✅ testUsersEndpoints() - работа с пользователями
 * ✅ testStatsEndpoints() - получение статистики
 */

/**
 * Команды для тестирования внутренних HTTP-запросов к API:
 * # Протестировать все эндпоинты
 * - php artisan app:test-request --endpoint=all
 * 
 * # Только задачи
 * - php artisan app:test-request --endpoint=tasks
 * 
 * # Только аутентификация
 * - php artisan app:test-request --endpoint=auth
 * 
 * # Только пользователи
 * - php artisan app:test-request --endpoint=users
 * 
 * # Только статистика
 * - php artisan app:test-request --endpoint=stats
 */

class TestRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-request {--endpoint=all : Specific endpoint to test (all, tasks, auth, users, stats)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test internal HTTP requests to API endpoints';

    /**
     * Base URL for API requests
     *
     * @var string
     */
    private $baseUrl;

    /**
     * Authentication token
     *
     * @var string|null
     */
    private $token;

    /**
     * Authenticated user
     *
     * @var \App\Models\User|null
     */
    private $user;

    /**
     * Test results tracker
     *
     * @var array
     */
    private $results = [
        'passed' => 0,
        'failed' => 0,
        'optional_failed' => 0,
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Detect if Laravel server is running
        $appUrl = config('app.url');
        $this->baseUrl = $appUrl;
        $endpoint = $this->option('endpoint');

        $this->info('🚀 Starting HTTP Request Tests...');
        $this->info("📡 Target URL: {$this->baseUrl}");
        $this->newLine();

        // Check if server is accessible
        if (!$this->checkServerAvailability()) {
            $this->error('❌ Cannot connect to the server!');
            $this->newLine();
            $this->warn('Please start the Laravel development server first:');
            $this->line('  php artisan serve');
            $this->line('Or if using custom port:');
            $this->line('  php artisan serve --port=8000');
            $this->newLine();
            $this->info('Then update your .env file:');
            $this->line('  APP_URL=http://localhost:8000');
            return 1;
        }

        $this->info('✓ Server is accessible');
        $this->newLine();

        // Authenticate first
        $this->authenticateUser();

        match($endpoint) {
            'tasks' => $this->testTasksEndpoints(),
            'auth' => $this->testAuthEndpoints(),
            'users' => $this->testUsersEndpoints(),
            'stats' => $this->testStatsEndpoints(),
            default => $this->testAllEndpoints(),
        };
        
        $this->newLine();
        $this->displayTestSummary();
        $this->info('✅ All tests completed!');
    }

    /**
     * Display test summary
     */
    private function displayTestSummary()
    {
        $this->info('📋 Test Summary:');
        $this->line("  ✓ Passed: {$this->results['passed']}");
        
        if ($this->results['failed'] > 0) {
            $this->error("  ✗ Failed (Required): {$this->results['failed']}");
        }
        
        if ($this->results['optional_failed'] > 0) {
            $this->warn("  ⚠ Failed (Optional): {$this->results['optional_failed']}");
        }
        
        $total = $this->results['passed'] + $this->results['failed'] + $this->results['optional_failed'];
        $successRate = $total > 0 ? round(($this->results['passed'] / $total) * 100, 2) : 0;
        
        $this->newLine();
        $this->info("  Success Rate: {$successRate}%");
    }

    /**
     * Check if server is available
     */
    private function checkServerAvailability(): bool
    {
        try {
            $response = Http::timeout(3)->get(config('app.url'));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Authenticate and get token
     */
    private function authenticateUser()
    {
        $this->info('🔐 Authenticating user...');

        // Get first user or create test user
        $this->user = User::first();
        
        if (!$this->user) {
            $this->error('No users found in database. Please create a user first.');
            return;
        }

        try {
            // Create token for testing using Sanctum
            $this->token = $this->user->createToken('test-token')->plainTextToken;
            $this->info("✓ Authenticated as: {$this->user->email}");
            $this->info("✓ Using Sanctum Token Authentication");
        } catch (\Exception $e) {
            $this->warn('⚠ Sanctum token creation failed. Tests will use user context.');
            $this->warn('Note: Make sure Laravel Sanctum is installed: composer require laravel/sanctum');
            $this->token = null;
            $this->info("✓ User context set: {$this->user->email}");
        }
        
        $this->newLine();
    }

    /**
     * Test all endpoints
     */
    private function testAllEndpoints()
    {
        $this->testTasksEndpoints();
        $this->testAuthEndpoints();
        $this->testUsersEndpoints();
        $this->testStatsEndpoints();
    }

    /**
     * Test Tasks API endpoints
     */
    private function testTasksEndpoints()
    {
        $this->info('📝 Testing Tasks Endpoints:');
        $this->newLine();

        // GET /tasks - List all tasks
        $this->testRequest('GET', '/tasks', 'Fetch all tasks');

        // POST /tasks - Create new task
        $taskData = [
            'title' => 'Test Task ' . now()->timestamp,
            'description' => 'This is a test task created via command',
            'priority' => 'medium',
            'status' => 'pending',
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ];
        $response = $this->testRequest('POST', '/tasks', 'Create new task', $taskData);

        if ($response && $response->successful()) {
            // Try to get task ID from response
            $responseData = $response->json();
            $taskId = $responseData['id'] ?? $responseData['data']['id'] ?? null;

            if ($taskId) {
                // GET /tasks/{id} - Get specific task
                $this->testRequest('GET', "/tasks/{$taskId}", "Fetch task #{$taskId}");

                // PATCH /tasks/{id} - Update task
                $updateData = [
                    'title' => 'Updated Test Task',
                    'status' => 'in_progress',
                ];
                $this->testRequest('PATCH', "/tasks/{$taskId}", "Update task #{$taskId}", $updateData);

                // DELETE /tasks/{id} - Delete task
                $this->testRequest('DELETE', "/tasks/{$taskId}", "Delete task #{$taskId}");
            }
        }

        // Additional Task Tests
        $this->testRequest('GET', '/tasks/export/json', 'Export tasks as JSON', [], false);
        
        $this->newLine();
    }

    /**
     * Test Authentication endpoints
     */
    private function testAuthEndpoints()
    {
        $this->info('🔑 Testing Authentication Endpoints:');
        $this->newLine();

        // GET /api/user - Get authenticated user
        $this->testRequest('GET', '/api/user', 'Fetch authenticated user');

        // POST /logout - Logout
        $this->testRequest('POST', '/logout', 'Logout user', [], false);

        $this->newLine();
    }

    /**
     * Test Users endpoints
     */
    private function testUsersEndpoints()
    {
        $this->info('👥 Testing Users Endpoints:');
        $this->newLine();

        // GET /profile - User profile
        $this->testRequest('GET', '/profile', 'Fetch user profile', [], false);

        $this->newLine();
    }

    /**
     * Test Statistics endpoints
     */
    private function testStatsEndpoints()
    {
        $this->info('📊 Testing Statistics Endpoints:');
        $this->newLine();

        // GET /api/statistics - Statistics
        $this->testRequest('GET', '/api/statistics', 'Fetch statistics');

        // GET /dashboard - Dashboard data
        $this->testRequest('GET', '/dashboard', 'Fetch dashboard data', [], false);

        // GET /api/notifications - Notifications (may fail if VAPID not configured)
        $this->info('  ℹ️  Note: Notifications endpoint requires VAPID keys configuration');
        $this->testRequest('GET', '/api/notifications', 'Fetch notifications', [], false);

        // GET /api/achievements/progress - Achievement progress
        $this->testRequest('GET', '/api/achievements/progress', 'Fetch achievements progress');

        $this->newLine();
    }

    /**
     * Make HTTP request and display results
     *
     * @param string $method
     * @param string $endpoint
     * @param string $description
     * @param array $data
     * @param bool $required
     * @return \Illuminate\Http\Client\Response|null
     */
    private function testRequest(string $method, string $endpoint, string $description, array $data = [], bool $required = true)
    {
        $url = $this->baseUrl . $endpoint;
        
        try {
            $this->line("  Testing: {$description}");
            $this->line("  Method: {$method} {$endpoint}");

            // Build request with token if available
            $request = Http::accept('application/json')
                ->withHeaders([
                    'X-Requested-With' => 'XMLHttpRequest',
                    'Referer' => $this->baseUrl,
                ]);
            
            if ($this->token) {
                $request = $request->withToken($this->token);
            }

            // Add CSRF token for state-changing operations
            if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
                // For web routes, we might need CSRF token
                // In testing context with API token, this should work
                $request = $request->withHeaders([
                    'X-CSRF-TOKEN' => 'test-token',
                ]);
            }

            $response = match(strtoupper($method)) {
                'GET' => $request->get($url, $data),
                'POST' => $request->post($url, $data),
                'PUT' => $request->put($url, $data),
                'PATCH' => $request->patch($url, $data),
                'DELETE' => $request->delete($url, $data),
                default => throw new \Exception("Unsupported HTTP method: {$method}"),
            };

            if ($response->successful()) {
                $this->info("  ✓ Status: {$response->status()} - Success");
                $this->results['passed']++;
                
                $responseData = $response->json();
                if ($responseData) {
                    $this->line("  Response: " . json_encode($responseData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                }
            } else {
                $message = "  ✗ Status: {$response->status()} - Failed";
                
                if ($required) {
                    $this->error($message);
                    $this->line("  Error: " . $response->body());
                    $this->results['failed']++;
                } else {
                    $this->warn($message . ' (optional endpoint)');
                    $this->results['optional_failed']++;
                }
            }

            $this->newLine();
            return $response;

        } catch (\Exception $e) {
            $message = "  ✗ Exception: {$e->getMessage()}";
            
            if ($required) {
                $this->error($message);
                $this->results['failed']++;
            } else {
                $this->warn($message . ' (optional endpoint)');
                $this->results['optional_failed']++;
            }
            
            $this->newLine();
            return null;
        }
    }
}
