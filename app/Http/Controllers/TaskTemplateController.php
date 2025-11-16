<?php

namespace App\Http\Controllers;

use App\Models\TaskTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskTemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = TaskTemplate::query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'templates' => $templates,
            ]);
        }

        return view('templates.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'priority' => ['nullable', 'in:low,medium,high'],
            'reminders_enabled' => ['boolean'],
            'default_due_days' => ['nullable', 'integer', 'min:0', 'max:365'],
        ]);

        $template = TaskTemplate::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'title' => $validated['title'] ?? null,
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'] ?? null,
            'reminders_enabled' => (bool)($validated['reminders_enabled'] ?? false),
            'default_due_days' => $validated['default_due_days'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'template' => $template,
            'message' => 'Шаблон сохранён',
        ], 201);
    }

    public function update(Request $request, TaskTemplate $template)
    {
        if ($template->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Недостаточно прав'], 403);
        }

        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:100'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'priority' => ['nullable', 'in:low,medium,high'],
            'reminders_enabled' => ['boolean'],
            'default_due_days' => ['nullable', 'integer', 'min:0', 'max:365'],
        ]);

        $template->fill($validated);
        $template->save();

        return response()->json([
            'success' => true,
            'template' => $template,
            'message' => 'Шаблон обновлён',
        ]);
    }

    public function destroy(TaskTemplate $template)
    {
        if ($template->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Недостаточно прав'], 403);
        }

        $template->delete();

        return response()->json([
            'success' => true,
            'message' => 'Шаблон удалён',
        ]);
    }

    public function apply(TaskTemplate $template)
    {
        if ($template->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Недостаточно прав'], 403);
        }

        $data = $template->only(['title', 'description', 'priority', 'reminders_enabled', 'default_due_days']);

        $dueDate = null;
        if (!empty($template->default_due_days)) {
            $dueDate = now()->addDays((int) $template->default_due_days)->format('Y-m-d');
        }

        return response()->json([
            'success' => true,
            'data' => array_merge($data, ['due_date' => $dueDate]),
        ]);
    }

    public function show(TaskTemplate $template)
    {
        if ($template->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Недостаточно прав'], 403);
        }

        return response()->json([
            'success' => true,
            'template' => $template,
        ]);
    }

    public function export(Request $request)
    {
        $templates = TaskTemplate::query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($t) => $t->only(['name', 'title', 'description', 'priority', 'reminders_enabled', 'default_due_days']));

        $filename = 'task_templates_' . now()->format('Y-m-d_H-i-s') . '.json';

        return response()->json($templates, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:json', 'max:2048'],
        ]);

        $file = $request->file('file');
        $content = file_get_contents($file->getRealPath());
        $data = json_decode($content, true);

        if (!is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Неверный формат файла'], 400);
        }

        $imported = 0;
        foreach ($data as $item) {
            if (empty($item['name'])) continue;

            TaskTemplate::create([
                'user_id' => Auth::id(),
                'name' => $item['name'],
                'title' => $item['title'] ?? null,
                'description' => $item['description'] ?? null,
                'priority' => $item['priority'] ?? null,
                'reminders_enabled' => (bool)($item['reminders_enabled'] ?? false),
                'default_due_days' => $item['default_due_days'] ?? null,
            ]);
            $imported++;
        }

        return response()->json([
            'success' => true,
            'message' => "Импортировано шаблонов: $imported",
            'imported' => $imported,
        ]);
    }
}
