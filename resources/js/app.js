import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Импорт дополнительных компонентов
import './components';

// Импорт утилит доступности
import './a11y';
import './toast';

// Импорт мониторинга ошибок и производительности
import './monitor';

// Push уведомления
import './push';
import './profile-reminders';