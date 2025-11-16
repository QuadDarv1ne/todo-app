# TODO App - Современное приложение для управления задачами

Полнофункциональное веб-приложение на Laravel для управления задачами с поддержкой PWA, Web Push уведомлений, тёмной темы и умных напоминаний.

## 🚀 Возможности

### Основные функции

- ✅ Аутентификация пользователей (регистрация, вход, выход)
- 📝 Создание, редактирование и удаление задач
- 🎯 Приоритеты задач (низкий, средний, высокий)
- 📅 Сроки выполнения задач
- 🔄 Drag & drop для изменения порядка задач
- 🔍 Фильтрация задач (все, активные, завершенные)
- 🏆 Система достижений и геймификация
- 📈 История активности и аналитика
- 💰 Система донатов
- 📤 Экспорт задач (JSON, CSV, PDF)

### Продвинутые функции

- 📱 **PWA** - установка как нативное приложение
- 🔔 **Web Push** - браузерные уведомления о дедлайнах
- 🌓 **Тёмная тема** - автоматическое переключение
- ⏰ **Умные напоминания** - персональное время отправки
- 🔐 **Безопасность** - CSP, CSRF, XSS защита
- ♿ **Доступность** - ARIA, клавиатурная навигация, screen reader
- 🚄 **Производительность** - кэширование, offline-режим, gzip
- 📊 **Мониторинг** - отслеживание клиентских ошибок и производительности
- 🎨 **UI/UX** - Tailwind CSS, Alpine.js, тост-уведомления
- 🔍 **SEO** - мета-теги, sitemap, robots.txt

### Новые возможности v2.0

- 📦 **Массовые операции** - выполнение, удаление и изменение приоритета группы задач
- ⌨️ **Горячие клавиши** - быстрое управление (N - новая, F - поиск, A - выбрать все, / - справка)
- 📈 **Расширенная аналитика** - Heat Map активности, графики продуктивности, тренды
- 🎯 **Умная статистика** - визуализация данных с Chart.js, распределение по приоритетам

## Установка

1. Клонируйте репозиторий:

   ```bash
   git clone https://github.com/ваш-логин/todo-app.git
   cd todo-app
   ```

2. Установите зависимости:

   ```bash
   composer install
   npm install
   ```

3. Создайте файл окружения и сгенерируйте ключ приложения:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Настройте базу данных в файле `.env`

5. Выполните миграции:

   ```bash
   php artisan migrate
   ```

6. Соберите фронтенд-ресурсы:

   ```bash
   npm run build
   ```

7. Запустите сервер разработки:

   ```bash
   php artisan serve
   ```

## Настройка напоминаний

Для работы системы напоминаний необходимо настроить планировщик задач:

1. Добавьте следующую запись в crontab:

   ```bash
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

2. Или запустите команду вручную для тестирования:

   ```bash
   php artisan tasks:send-reminders --days=1
   ```

## Тестирование

Для запуска тестов выполните:

```bash
php artisan test
```

## Документация

- [Новые возможности v2.0](NEW_FEATURES.md) - Подробное описание массовых операций, горячих клавиш и аналитики
- [Инструкция по установке и настройке](README-note.md)
- [Документация API](API_DOCS.md)
- [Описание улучшений версии 1.1](IMPROVEMENTS.md)
- [Документация на русском языке](README-ru.md)
- [Документация системы напоминаний](REMINDERS.md)

## О Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
