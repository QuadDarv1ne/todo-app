# Скрипт для запуска сервера с автоматической очисткой кеша при остановке

Write-Host "🚀 Запуск сервера разработки Laravel..." -ForegroundColor Green
Write-Host "Для остановки нажмите Ctrl+C" -ForegroundColor Yellow
Write-Host ""

# Обработчик сигнала остановки
$cleanup = {
    Write-Host ""
    Write-Host "⏹️  Остановка сервера..." -ForegroundColor Yellow
    Write-Host ""
    
    Write-Host "🧹 Очистка кеша..." -ForegroundColor Cyan
    
    # Очистка всех кешей
    php artisan cache:clear 2>&1 | Out-Null
    Write-Host "   ✓ Application cache cleared" -ForegroundColor Green
    
    php artisan config:clear 2>&1 | Out-Null
    Write-Host "   ✓ Configuration cache cleared" -ForegroundColor Green
    
    php artisan route:clear 2>&1 | Out-Null
    Write-Host "   ✓ Route cache cleared" -ForegroundColor Green
    
    php artisan view:clear 2>&1 | Out-Null
    Write-Host "   ✓ Compiled views cleared" -ForegroundColor Green
    
    Write-Host ""
    Write-Host "✨ Сервер остановлен и кеш очищен!" -ForegroundColor Green
    
    # Завершить процесс
    exit
}

# Регистрация обработчика
Register-EngineEvent PowerShell.Exiting -Action $cleanup

try {
    # Запуск сервера
    php artisan serve
}
catch {
    Write-Host "❌ Ошибка при запуске сервера: $_" -ForegroundColor Red
}
finally {
    # Вызов очистки при любом завершении
    & $cleanup
}
