# 🚀 Запуск сервера разработки

## Windows (PowerShell)

```powershell
.\serve.ps1
```

## Linux / macOS (Bash)

```bash
./serve.sh
```

## Что делают скрипты?

1. ✅ Запускают сервер разработки Laravel (`php artisan serve`)
2. ✅ При остановке (Ctrl+C) автоматически очищают:
   - Application cache
   - Configuration cache
   - Route cache
   - Compiled views cache

## Альтернативный запуск (без автоочистки)

```bash
php artisan serve
```

## Ручная очистка кеша

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

Или все сразу:

```bash
php artisan optimize:clear
```
