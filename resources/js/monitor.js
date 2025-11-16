// Простая отправка ошибок JS на сервер
function sendErrorToServer(message, source, lineno, colno, error) {
    try {
        window.axios.post('/api/log-js-error', {
            message,
            source,
            lineno,
            colno,
            stack: error && error.stack ? error.stack : null,
            userAgent: navigator.userAgent,
            url: window.location.href
        });
    } catch (e) {
        // Не логируем повторно
    }
}

window.onerror = sendErrorToServer;
window.addEventListener('unhandledrejection', function(event) {
    sendErrorToServer(
        event.reason ? event.reason.message : 'Unhandled promise rejection',
        '',
        0,
        0,
        event.reason
    );
});

// Отслеживание времени загрузки страницы
window.addEventListener('load', function() {
    setTimeout(() => {
        if (window.performance && window.performance.timing) {
            const timing = window.performance.timing;
            const loadTime = timing.loadEventEnd - timing.navigationStart;
            window.axios.post('/api/log-performance', {
                loadTime,
                userAgent: navigator.userAgent,
                url: window.location.href
            });
        }
    }, 1000);
});
