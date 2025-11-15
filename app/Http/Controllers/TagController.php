<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TagController extends Controller
{
    use AuthorizesRequests;

    /**
     * Получить все теги пользователя.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $tags = $request->user()->tags()->withCount('tasks')->get();
            
            return response()->json([
                'success' => true,
                'tags' => $tags
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching tags: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при получении тегов'
            ], 500);
        }
    }

    /**
     * Создать новый тег.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:50',
                'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            ]);

            // Проверка на уникальность имени для пользователя
            $exists = $request->user()->tags()->where('name', $validated['name'])->exists();
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Тег с таким именем уже существует'
                ], 422);
            }

            $tag = $request->user()->tags()->create($validated);

            return response()->json([
                'success' => true,
                'tag' => $tag
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating tag: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании тега'
            ], 500);
        }
    }

    /**
     * Обновить тег.
     */
    public function update(Request $request, Tag $tag): JsonResponse
    {
        try {
            $this->authorize('update', $tag);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:50',
                'color' => 'sometimes|required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            ]);

            // Проверка на уникальность имени (если оно изменилось)
            if (isset($validated['name']) && $validated['name'] !== $tag->name) {
                $exists = $request->user()->tags()
                    ->where('name', $validated['name'])
                    ->where('id', '!=', $tag->id)
                    ->exists();
                    
                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Тег с таким именем уже существует'
                    ], 422);
                }
            }

            $tag->update($validated);

            return response()->json([
                'success' => true,
                'tag' => $tag
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating tag: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении тега'
            ], 500);
        }
    }

    /**
     * Удалить тег.
     */
    public function destroy(Tag $tag): JsonResponse
    {
        try {
            $this->authorize('delete', $tag);
            $tag->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error deleting tag: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении тега'
            ], 500);
        }
    }

    /**
     * Прикрепить тег к задаче.
     */
    public function attach(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'task_id' => 'required|exists:tasks,id',
                'tag_id' => 'required|exists:tags,id',
            ]);

            $task = \App\Models\Task::findOrFail($validated['task_id']);
            $this->authorize('update', $task);

            $tag = Tag::findOrFail($validated['tag_id']);
            $this->authorize('view', $tag);

            if (!$task->tags()->where('tag_id', $tag->id)->exists()) {
                $task->tags()->attach($tag->id);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error attaching tag: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при добавлении тега'
            ], 500);
        }
    }

    /**
     * Открепить тег от задачи.
     */
    public function detach(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'task_id' => 'required|exists:tasks,id',
                'tag_id' => 'required|exists:tags,id',
            ]);

            $task = \App\Models\Task::findOrFail($validated['task_id']);
            $this->authorize('update', $task);

            $task->tags()->detach($validated['tag_id']);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error detaching tag: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении тега'
            ], 500);
        }
    }
}
