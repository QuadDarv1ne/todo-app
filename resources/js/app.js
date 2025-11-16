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

// Массовые операции с задачами
import './bulk-operations';

// Горячие клавиши
import './keyboard-shortcuts';

// Расширенная аналитика
import './analytics';

// Подзадачи (чек-листы)
import './subtasks';

// Шаблоны задач
import './templates';

// Drag-and-drop для задач
import './drag-drop';

// Улучшенный поиск с подсветкой
import './enhanced-search';

// Умные фильтры с запоминанием
import './smart-filters';