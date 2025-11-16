/**
 * Модуль расширенной аналитики
 * Визуализация данных о продуктивности и активности
 */

class Analytics {
    constructor() {
        this.charts = {};
        this.data = null;
        this.init();
    }

    async init() {
        // Загружаем данные аналитики
        await this.loadData();
        
        // Инициализируем графики
        this.initCharts();
        
        // Создаем Heat Map активности
        this.createActivityHeatmap();
    }

    /**
     * Загрузка данных аналитики
     */
    async loadData() {
        try {
            const response = await fetch('/statistics', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            });
            
            if (response.ok) {
                this.data = await response.json();
            }
        } catch (error) {
            console.error('Error loading analytics data:', error);
        }
    }

    /**
     * Инициализация графиков
     */
    initCharts() {
        if (!this.data) return;

        // График производительности по дням недели
        this.createWeeklyProductivityChart();
        
        // График трендов выполнения
        this.createCompletionTrendChart();
        
        // График распределения по приоритетам
        this.createPriorityDistributionChart();
        
        // График использования тегов
        this.createTagUsageChart();
    }

    /**
     * График производительности по дням недели
     */
    createWeeklyProductivityChart() {
        const canvas = document.getElementById('weeklyProductivityChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const data = this.data.by_day_of_week || {};
        
        const daysOfWeek = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
        const completedData = daysOfWeek.map((_, i) => data[i + 1]?.completed || 0);
        const createdData = daysOfWeek.map((_, i) => data[i + 1]?.created || 0);

        this.charts.weekly = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: daysOfWeek,
                datasets: [
                    {
                        label: 'Выполнено',
                        data: completedData,
                        backgroundColor: 'rgba(34, 197, 94, 0.8)',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 2,
                        borderRadius: 8,
                    },
                    {
                        label: 'Создано',
                        data: createdData,
                        backgroundColor: 'rgba(99, 102, 241, 0.8)',
                        borderColor: 'rgb(99, 102, 241)',
                        borderWidth: 2,
                        borderRadius: 8,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: { size: 12, weight: 'bold' }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Продуктивность по дням недели',
                        font: { size: 16, weight: 'bold' },
                        padding: 20
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    /**
     * График трендов выполнения задач
     */
    createCompletionTrendChart() {
        const canvas = document.getElementById('completionTrendChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const trendData = this.data.advanced?.completion_trend || {};
        
        const dates = Object.keys(trendData).slice(-30); // Последние 30 дней
        const values = dates.map(date => trendData[date]);

        this.charts.trend = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates.map(date => {
                    const d = new Date(date);
                    return `${d.getDate()}.${d.getMonth() + 1}`;
                }),
                datasets: [{
                    label: 'Выполненные задачи',
                    data: values,
                    borderColor: 'rgb(99, 102, 241)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgb(99, 102, 241)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Тренд выполнения (30 дней)',
                        font: { size: 16, weight: 'bold' },
                        padding: 20
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    /**
     * График распределения по приоритетам
     */
    createPriorityDistributionChart() {
        const canvas = document.getElementById('priorityDistributionChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const priorities = this.data.advanced?.by_priority || {};

        this.charts.priority = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Высокий', 'Средний', 'Низкий'],
                datasets: [{
                    data: [
                        priorities.high || 0,
                        priorities.medium || 0,
                        priorities.low || 0
                    ],
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(234, 179, 8, 0.8)',
                        'rgba(34, 197, 94, 0.8)'
                    ],
                    borderColor: [
                        'rgb(239, 68, 68)',
                        'rgb(234, 179, 8)',
                        'rgb(34, 197, 94)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: { size: 12, weight: 'bold' }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Распределение по приоритетам',
                        font: { size: 16, weight: 'bold' },
                        padding: 20
                    }
                }
            }
        });
    }

    /**
     * График использования тегов
     */
    createTagUsageChart() {
        const canvas = document.getElementById('tagUsageChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const tags = this.data.tags || [];
        
        // Топ 10 тегов
        const topTags = tags
            .sort((a, b) => b.tasks_count - a.tasks_count)
            .slice(0, 10);

        this.charts.tags = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: topTags.map(tag => tag.name),
                datasets: [{
                    label: 'Количество задач',
                    data: topTags.map(tag => tag.tasks_count),
                    backgroundColor: 'rgba(147, 51, 234, 0.8)',
                    borderColor: 'rgb(147, 51, 234)',
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Топ-10 тегов',
                        font: { size: 16, weight: 'bold' },
                        padding: 20
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    /**
     * Создание Heat Map активности
     */
    createActivityHeatmap() {
        const container = document.getElementById('activityHeatmap');
        if (!container || !this.data) return;

        // Генерируем данные за последние 365 дней
        const today = new Date();
        const yearAgo = new Date();
        yearAgo.setDate(today.getDate() - 365);

        const completionTrend = this.data.advanced?.completion_trend || {};
        
        let html = '<div class="grid gap-1" style="grid-template-columns: repeat(53, 1fr);">';
        
        for (let week = 0; week < 53; week++) {
            html += '<div class="flex flex-col gap-1">';
            for (let day = 0; day < 7; day++) {
                const date = new Date(yearAgo);
                date.setDate(yearAgo.getDate() + (week * 7) + day);
                
                if (date > today) continue;
                
                const dateStr = date.toISOString().split('T')[0];
                const count = completionTrend[dateStr] || 0;
                
                const intensity = count === 0 ? 'bg-gray-100 dark:bg-gray-800' :
                                count === 1 ? 'bg-green-200 dark:bg-green-900' :
                                count === 2 ? 'bg-green-400 dark:bg-green-700' :
                                count >= 3 ? 'bg-green-600 dark:bg-green-500' : 'bg-gray-100';
                
                html += `<div class="w-3 h-3 rounded-sm ${intensity}" 
                             title="${dateStr}: ${count} задач(и)"
                             data-date="${dateStr}"
                             data-count="${count}"></div>`;
            }
            html += '</div>';
        }
        
        html += '</div>';
        
        container.innerHTML = html;

        // Добавляем легенду
        const legend = `
            <div class="mt-4 flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <span>Меньше</span>
                <div class="w-3 h-3 bg-gray-100 dark:bg-gray-800 rounded-sm"></div>
                <div class="w-3 h-3 bg-green-200 dark:bg-green-900 rounded-sm"></div>
                <div class="w-3 h-3 bg-green-400 dark:bg-green-700 rounded-sm"></div>
                <div class="w-3 h-3 bg-green-600 dark:bg-green-500 rounded-sm"></div>
                <span>Больше</span>
            </div>
        `;
        
        container.insertAdjacentHTML('afterend', legend);
    }

    /**
     * Обновление всех графиков
     */
    async refresh() {
        await this.loadData();
        
        // Уничтожаем старые графики
        Object.values(this.charts).forEach(chart => chart.destroy());
        this.charts = {};
        
        // Создаем новые
        this.initCharts();
        this.createActivityHeatmap();
    }
}

// Инициализация на странице статистики
if (typeof window !== 'undefined') {
    document.addEventListener('DOMContentLoaded', () => {
        if (document.getElementById('weeklyProductivityChart') || 
            document.getElementById('activityHeatmap')) {
            window.analytics = new Analytics();
        }
    });
}

export default Analytics;
