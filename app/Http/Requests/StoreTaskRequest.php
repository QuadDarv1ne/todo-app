<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NotPastDate;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:65535',
            'due_date' => ['nullable', 'date', new NotPastDate()],
            'priority' => 'nullable|string|in:low,medium,high',
            'reminders_enabled' => 'nullable|boolean',
            'is_recurring' => 'nullable|boolean',
            'recurrence_type' => 'nullable|required_if:is_recurring,true|in:daily,weekly,monthly,yearly',
            'recurrence_interval' => 'nullable|integer|min:1|max:365',
            'recurrence_end_date' => 'nullable|date|after_or_equal:due_date',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Название задачи обязательно для заполнения.',
            'title.string' => 'Название задачи должно быть строкой.',
            'title.max' => 'Название задачи не может превышать 255 символов.',
            'description.string' => 'Описание задачи должно быть строкой.',
            'description.max' => 'Описание задачи не может превышать 65535 символов.',
            'due_date.date' => 'Дата выполнения должна быть корректной датой.',
            'priority.in' => 'Приоритет должен быть одним из: низкий, средний, высокий.',
        ];
    }
}