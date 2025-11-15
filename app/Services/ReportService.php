<?php

namespace App\Services;

use App\Models\User;
use App\Helpers\TaskHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class ReportService
{
    /**
     * Генерация PDF отчета по задачам пользователя.
     *
     * @param User $user
     * @param array $options
     * @return \Illuminate\Http\Response
     */
    public function generateTaskReport(User $user, array $options = [])
    {
        $includeCompleted = $options['include_completed'] ?? true;
        $includePending = $options['include_pending'] ?? true;
        $includeStatistics = $options['include_statistics'] ?? true;
        $includeTags = $options['include_tags'] ?? true;

        // Получаем данные
        $data = $this->prepareReportData($user, [
            'include_completed' => $includeCompleted,
            'include_pending' => $includePending,
            'include_statistics' => $includeStatistics,
            'include_tags' => $includeTags,
        ]);

        // Генерируем PDF
        $pdf = Pdf::loadView('reports.task-report', $data);
        
        // Настройки PDF
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('defaultFont', 'DejaVu Sans');

        return $pdf;
    }

    /**
     * Подготовка данных для отчета.
     *
     * @param User $user
     * @param array $options
     * @return array
     */
    private function prepareReportData(User $user, array $options): array
    {
        $data = [
            'user' => $user,
            'generated_at' => now(),
        ];

        // Статистика
        if ($options['include_statistics']) {
            $data['stats'] = TaskHelper::getUserTaskStats($user);
            $data['advanced_stats'] = TaskHelper::getAdvancedStats($user);
        }

        // Завершенные задачи
        if ($options['include_completed']) {
            $data['completed_tasks'] = $user->tasks()
                ->where('completed', true)
                ->with('tags')
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        // Активные задачи
        if ($options['include_pending']) {
            $data['pending_tasks'] = $user->tasks()
                ->where('completed', false)
                ->with('tags')
                ->orderBy('priority', 'desc')
                ->orderBy('due_date', 'asc')
                ->get();
        }

        // Статистика по тегам
        if ($options['include_tags']) {
            $data['tag_stats'] = TaskHelper::getTagStats($user);
        }

        return $data;
    }

    /**
     * Генерация статистического отчета.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function generateStatisticsReport(User $user)
    {
        $data = [
            'user' => $user,
            'generated_at' => now(),
            'basic_stats' => TaskHelper::getUserTaskStats($user),
            'advanced_stats' => TaskHelper::getAdvancedStats($user),
            'tag_stats' => TaskHelper::getTagStats($user),
            'tasks_by_day' => TaskHelper::getTasksByDayOfWeek($user),
        ];

        $pdf = Pdf::loadView('reports.statistics-report', $data);
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption('defaultFont', 'DejaVu Sans');

        return $pdf;
    }

    /**
     * Экспорт задач в формате PDF (список).
     *
     * @param User $user
     * @param string $filter
     * @return \Illuminate\Http\Response
     */
    public function exportTasksToPdf(User $user, string $filter = 'all')
    {
        $query = TaskHelper::getFilteredTasks($user, $filter);
        $tasks = $query->with('tags')->orderBy('order')->get();

        $data = [
            'user' => $user,
            'tasks' => $tasks,
            'filter' => $filter,
            'generated_at' => now(),
        ];

        $pdf = Pdf::loadView('reports.tasks-list', $data);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('defaultFont', 'DejaVu Sans');

        return $pdf;
    }
}
