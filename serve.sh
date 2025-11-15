#!/bin/bash

# Скрипт для запуска сервера с автоматической очисткой кеша при остановке (для Linux/Mac)

echo "🚀 Запуск сервера разработки Laravel..."
echo "Для остановки нажмите Ctrl+C"
echo ""

# Функция очистки кеша
cleanup() {
    echo ""
    echo "⏹️  Остановка сервера..."
    echo ""
    
    echo "🧹 Очистка кеша..."
    
    # Очистка всех кешей
    php artisan cache:clear > /dev/null 2>&1
    echo "   ✓ Application cache cleared"
    
    php artisan config:clear > /dev/null 2>&1
    echo "   ✓ Configuration cache cleared"
    
    php artisan route:clear > /dev/null 2>&1
    echo "   ✓ Route cache cleared"
    
    php artisan view:clear > /dev/null 2>&1
    echo "   ✓ Compiled views cleared"
    
    echo ""
    echo "✨ Сервер остановлен и кеш очищен!"
    
    exit 0
}

# Регистрация обработчика сигналов
trap cleanup SIGINT SIGTERM

# Запуск сервера
php artisan serve

# Если сервер завершился нормально, тоже очистить кеш
cleanup
