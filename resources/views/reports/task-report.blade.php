<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отчет по задачам - {{ $user->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #4F46E5;
        }
        .header h1 {
            color: #4F46E5;
            margin: 0 0 10px 0;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .stat-box {
            display: table-cell;
            width: 33.33%;
            padding: 15px;
            text-align: center;
            background: #F3F4F6;
            border-radius: 8px;
        }
        .stat-box + .stat-box {
            margin-left: 10px;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #4F46E5;
        }
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            color: #1F2937;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #E5E7EB;
        }
        .task-item {
            padding: 12px;
            margin-bottom: 10px;
            background: #F9FAFB;
            border-left: 4px solid #4F46E5;
            border-radius: 4px;
        }
        .task-item.completed {
            border-left-color: #10B981;
        }
        .task-item.high-priority {
            border-left-color: #EF4444;
        }
        .task-item.medium-priority {
            border-left-color: #F59E0B;
        }
        .task-item.low-priority {
            border-left-color: #10B981;
        }
        .task-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .task-description {
            color: #666;
            font-size: 11px;
            margin-bottom: 8px;
        }
        .task-meta {
            font-size: 10px;
            color: #999;
        }
        .tag {
            display: inline-block;
            padding: 2px 8px;
            margin-right: 5px;
            background: #E0E7FF;
            color: #4338CA;
            border-radius: 12px;
            font-size: 10px;
        }
        .priority-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        .priority-high {
            background: #FEE2E2;
            color: #991B1B;
        }
        .priority-medium {
            background: #FEF3C7;
            color: #92400E;
        }
        .priority-low {
            background: #D1FAE5;
            color: #065F46;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        .progress-bar {
            width: 100%;
            height: 20px;
            background: #E5E7EB;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px 0;
        }
        .progress-fill {
            height: 100%;
            background: #4F46E5;
            text-align: center;
            line-height: 20px;
            color: white;
            font-size: 11px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Отчет по задачам</h1>
        <p><strong>Пользователь:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Дата формирования:</strong> {{ $generated_at->format('d.m.Y H:i') }}</p>
    </div>

    <!-- Статистика -->
    @if(isset($stats))
    <div class="section">
        <div class="section-title">Общая статистика</div>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Всего задач</div>
            </div>
            <div class="stat-box" style="margin-left: 10px;">
                <div class="stat-value" style="color: #10B981;">{{ $stats['completed'] }}</div>
                <div class="stat-label">Завершено</div>
            </div>
            <div class="stat-box" style="margin-left: 10px;">
                <div class="stat-value" style="color: #F59E0B;">{{ $stats['pending'] }}</div>
                <div class="stat-label">В процессе</div>
            </div>
        </div>

        @if($stats['total'] > 0)
        <div class="progress-bar">
            <div class="progress-fill" style="width: {{ $stats['completion_percentage'] }}%">
                {{ $stats['completion_percentage'] }}%
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Расширенная статистика -->
    @if(isset($advanced_stats))
    <div class="section">
        <div class="section-title">Детальная статистика</div>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px; background: #F9FAFB;">Просроченные задачи:</td>
                <td style="padding: 8px; font-weight: bold;">{{ $advanced_stats['overdue'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; background: #F9FAFB;">Высокий приоритет:</td>
                <td style="padding: 8px; font-weight: bold;">{{ $advanced_stats['high_priority'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; background: #F9FAFB;">Средний приоритет:</td>
                <td style="padding: 8px; font-weight: bold;">{{ $advanced_stats['medium_priority'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; background: #F9FAFB;">Низкий приоритет:</td>
                <td style="padding: 8px; font-weight: bold;">{{ $advanced_stats['low_priority'] }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; background: #F9FAFB;">Задачи с тегами:</td>
                <td style="padding: 8px; font-weight: bold;">{{ $advanced_stats['with_tags'] }}</td>
            </tr>
        </table>
    </div>
    @endif

    <!-- Активные задачи -->
    @if(isset($pending_tasks) && $pending_tasks->count() > 0)
    <div class="section">
        <div class="section-title">Активные задачи ({{ $pending_tasks->count() }})</div>
        @foreach($pending_tasks as $task)
        <div class="task-item {{ $task->priority }}-priority">
            <div class="task-title">
                {{ $task->title }}
                <span class="priority-badge priority-{{ $task->priority }}">{{ $task->priority_name }}</span>
            </div>
            @if($task->description)
            <div class="task-description">{{ Str::limit($task->description, 200) }}</div>
            @endif
            <div class="task-meta">
                @if($task->due_date)
                    Срок: {{ $task->due_date->format('d.m.Y') }} |
                @endif
                Создано: {{ $task->created_at->format('d.m.Y') }}
                @if($task->tags->count() > 0)
                    <br>Теги:
                    @foreach($task->tags as $tag)
                        <span class="tag">{{ $tag->name }}</span>
                    @endforeach
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Завершенные задачи -->
    @if(isset($completed_tasks) && $completed_tasks->count() > 0)
    <div class="section" style="page-break-before: always;">
        <div class="section-title">Завершенные задачи ({{ $completed_tasks->count() }})</div>
        @foreach($completed_tasks as $task)
        <div class="task-item completed">
            <div class="task-title">{{ $task->title }}</div>
            @if($task->description)
            <div class="task-description">{{ Str::limit($task->description, 150) }}</div>
            @endif
            <div class="task-meta">
                Завершено: {{ $task->updated_at->format('d.m.Y H:i') }}
                @if($task->tags->count() > 0)
                    <br>Теги:
                    @foreach($task->tags as $tag)
                        <span class="tag">{{ $tag->name }}</span>
                    @endforeach
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Статистика по тегам -->
    @if(isset($tag_stats) && count($tag_stats) > 0)
    <div class="section">
        <div class="section-title">Статистика по тегам</div>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #F3F4F6;">
                    <th style="padding: 8px; text-align: left;">Тег</th>
                    <th style="padding: 8px; text-align: center;">Количество задач</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tag_stats as $tag)
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #E5E7EB;">
                        <span class="tag">{{ $tag['name'] }}</span>
                    </td>
                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #E5E7EB; font-weight: bold;">
                        {{ $tag['tasks_count'] }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Отчет сгенерирован системой управления задачами Maestro7IT</p>
        <p>{{ $generated_at->format('d.m.Y H:i:s') }}</p>
    </div>
</body>
</html>
