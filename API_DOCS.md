# API Документация Todo-App

## Обзор

Данная документация описывает REST API для приложения управления задачами (Todo-App). Все запросы к API должны содержать CSRF-токен и требуют аутентификации пользователя.

## Базовый URL

```
http://localhost:8000
```

## Аутентификация

Все API endpoints требуют аутентификации через Laravel Sanctum или стандартную сессионную аутентификацию Laravel.

### Headers

```http
Content-Type: application/json
X-CSRF-TOKEN: {csrf_token}
```

## Endpoints

### 1. Получить список задач

Получает список задач текущего пользователя с возможностью фильтрации и поиска.

**Endpoint:** `GET /tasks`

**Параметры запроса:**

| Параметр | Тип    | Обязательный | Описание                                          |
|----------|--------|--------------|---------------------------------------------------|
| filter   | string | Нет          | Фильтр задач: `all`, `completed`, `pending`       |
| search   | string | Нет          | Поисковый запрос по заголовку и описанию          |
| page     | int    | Нет          | Номер страницы для пагинации (по умолчанию: 1)    |

**Пример запроса:**

```http
GET /tasks?filter=pending&search=important&page=1
```

**Пример ответа:**

Возвращает HTML-страницу со списком задач и пагинацией.

---

### 2. Получить одну задачу

Получает данные конкретной задачи в JSON формате.

**Endpoint:** `GET /tasks/{id}`

**Параметры пути:**

| Параметр | Тип | Описание       |
|----------|-----|----------------|
| id       | int | ID задачи      |

**Пример запроса:**

```http
GET /tasks/42
```

**Пример успешного ответа (200 OK):**

```json
{
  "success": true,
  "task": {
    "id": 42,
    "user_id": 1,
    "title": "Купить продукты",
    "description": "Молоко, хлеб, яйца",
    "completed": false,
    "order": 1,
    "due_date": "2025-11-20",
    "created_at": "2025-11-15T10:30:00.000000Z",
    "updated_at": "2025-11-15T10:30:00.000000Z"
  }
}
```

**Пример ответа с ошибкой (403 Forbidden):**

```json
{
  "success": false,
  "message": "У вас нет прав для просмотра этой задачи"
}
```

---

### 3. Создать задачу

Создает новую задачу для текущего пользователя.

**Endpoint:** `POST /tasks`

**Тело запроса:**

| Поле        | Тип    | Обязательный | Описание                              |
|-------------|--------|--------------|---------------------------------------|
| title       | string | Да           | Заголовок задачи (макс. 255 символов) |
| description | string | Нет          | Описание задачи                       |
| due_date    | date   | Нет          | Дата выполнения (формат: YYYY-MM-DD)  |

**Пример запроса:**

```http
POST /tasks
Content-Type: application/json

{
  "title": "Подготовить презентацию",
  "description": "Для встречи с клиентом в пятницу",
  "due_date": "2025-11-22"
}
```

**Пример успешного ответа (201 Created):**

```json
{
  "success": true,
  "task": {
    "id": 43,
    "title": "Подготовить презентацию",
    "description": "Для встречи с клиентом в пятницу",
    "completed": false,
    "order": 5,
    "due_date": "2025-11-22",
    "created_at": "2025-11-15T12:00:00.000000Z",
    "updated_at": "2025-11-15T12:00:00.000000Z"
  }
}
```

**Пример ответа с ошибкой валидации (422 Unprocessable Entity):**

```json
{
  "message": "The title field is required.",
  "errors": {
    "title": [
      "The title field is required."
    ]
  }
}
```

---

### 4. Обновить задачу

Обновляет существующую задачу (заголовок, описание, статус, дату выполнения).

**Endpoint:** `PATCH /tasks/{id}`

**Параметры пути:**

| Параметр | Тип | Описание  |
|----------|-----|-----------|
| id       | int | ID задачи |

**Тело запроса:**

| Поле        | Тип     | Обязательный | Описание                              |
|-------------|---------|--------------|---------------------------------------|
| title       | string  | Нет          | Заголовок задачи (макс. 255 символов) |
| description | string  | Нет          | Описание задачи                       |
| completed   | boolean | Нет          | Статус выполнения (true/false)        |
| due_date    | date    | Нет          | Дата выполнения (формат: YYYY-MM-DD)  |

**Пример запроса:**

```http
PATCH /tasks/43
Content-Type: application/json

{
  "title": "Подготовить презентацию (обновлено)",
  "completed": true
}
```

**Пример успешного ответа (200 OK):**

```json
{
  "success": true,
  "task": {
    "id": 43,
    "title": "Подготовить презентацию (обновлено)",
    "description": "Для встречи с клиентом в пятницу",
    "completed": true,
    "order": 5,
    "due_date": "2025-11-22",
    "updated_at": "2025-11-15T14:30:00.000000Z"
  }
}
```

**Пример ответа с ошибкой (403 Forbidden):**

```json
{
  "success": false,
  "message": "У вас нет прав для изменения этой задачи"
}
```

---

### 5. Удалить задачу

Удаляет задачу.

**Endpoint:** `DELETE /tasks/{id}`

**Параметры пути:**

| Параметр | Тип | Описание  |
|----------|-----|-----------|
| id       | int | ID задачи |

**Пример запроса:**

```http
DELETE /tasks/43
```

**Пример успешного ответа (200 OK):**

```json
{
  "success": true
}
```

**Пример ответа с ошибкой (403 Forbidden):**

```json
{
  "success": false,
  "message": "У вас нет прав для удаления этой задачи"
}
```

---

### 6. Изменить порядок задач

Обновляет порядок отображения задач (для функции drag & drop).

**Endpoint:** `POST /tasks/reorder`

**Тело запроса:**

| Поле         | Тип   | Обязательный | Описание                        |
|--------------|-------|--------------|----------------------------------|
| tasks        | array | Да           | Массив задач с новым порядком    |
| tasks[].id   | int   | Да           | ID задачи                        |
| tasks[].order| int   | Да           | Новый порядок задачи (от 0)      |

**Пример запроса:**

```http
POST /tasks/reorder
Content-Type: application/json

{
  "tasks": [
    {
      "id": 1,
      "order": 0
    },
    {
      "id": 3,
      "order": 1
    },
    {
      "id": 2,
      "order": 2
    }
  ]
}
```

**Пример успешного ответа (200 OK):**

```json
{
  "success": true
}
```

**Пример ответа с ошибкой (403 Forbidden):**

```json
{
  "success": false,
  "message": "Вы можете изменять только свои задачи"
}
```

---

## Коды ответов

| Код | Описание                                      |
|-----|-----------------------------------------------|
| 200 | OK - Успешный запрос                          |
| 201 | Created - Ресурс успешно создан               |
| 401 | Unauthorized - Требуется аутентификация       |
| 403 | Forbidden - Нет прав доступа к ресурсу        |
| 404 | Not Found - Ресурс не найден                  |
| 422 | Unprocessable Entity - Ошибка валидации       |
| 500 | Internal Server Error - Внутренняя ошибка     |

---

## Примеры использования

### JavaScript (Fetch API)

```javascript
// Создание задачи
async function createTask(title, description, dueDate) {
  const response = await fetch('/tasks', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
      title: title,
      description: description,
      due_date: dueDate
    })
  });
  
  return await response.json();
}

// Обновление статуса задачи
async function toggleTaskStatus(taskId, completed) {
  const response = await fetch(`/tasks/${taskId}`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({ completed })
  });
  
  return await response.json();
}

// Удаление задачи
async function deleteTask(taskId) {
  const response = await fetch(`/tasks/${taskId}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  });
  
  return await response.json();
}
```

### cURL

```bash
# Создание задачи
curl -X POST http://localhost:8000/tasks \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -d '{
    "title": "Новая задача",
    "description": "Описание задачи",
    "due_date": "2025-11-20"
  }'

# Получение списка задач
curl -X GET "http://localhost:8000/tasks?filter=pending&search=важно"

# Обновление задачи
curl -X PATCH http://localhost:8000/tasks/1 \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -d '{"completed": true}'

# Удаление задачи
curl -X DELETE http://localhost:8000/tasks/1 \
  -H "X-CSRF-TOKEN: your-csrf-token"
```

---

## Политики доступа

Приложение использует Laravel Policies для контроля доступа:

- **view**: Пользователь может просматривать только свои задачи
- **update**: Пользователь может обновлять только свои задачи
- **delete**: Пользователь может удалять только свои задачи

---

## Кэширование

API использует кэширование для улучшения производительности:

- Статистика задач пользователя кэшируется на 5 минут
- Последние задачи кэшируются на 5 минут
- Кэш автоматически очищается при создании, обновлении или удалении задач

---

## Валидация

### Правила валидации для создания задачи (POST /tasks)

- `title`: обязательное поле, строка, максимум 255 символов
- `description`: необязательное поле, строка
- `due_date`: необязательное поле, дата в формате YYYY-MM-DD

### Правила валидации для обновления задачи (PATCH /tasks/{id})

- `title`: необязательное поле, строка, максимум 255 символов
- `description`: необязательное поле, строка, может быть null
- `completed`: необязательное поле, boolean
- `due_date`: необязательное поле, дата в формате YYYY-MM-DD, может быть null

---

## Обработка ошибок

Все ошибки возвращаются в JSON формате:

```json
{
  "success": false,
  "message": "Описание ошибки"
}
```

Для ошибок валидации (422):

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field_name": [
      "Описание ошибки валидации"
    ]
  }
}
```

---

## Версионирование

Текущая версия API: **v1.0**

Дата последнего обновления: **15 ноября 2025**

---

## Дополнительная информация

Для получения дополнительной информации обратитесь к:

- [README.md](README.md) - Общая информация о проекте
- [README-note.md](README-note.md) - Инструкции по установке и настройке
- Исходный код контроллера: `app/Http/Controllers/TaskController.php`
- Модели запросов: `app/Http/Requests/StoreTaskRequest.php`, `app/Http/Requests/UpdateTaskRequest.php`
