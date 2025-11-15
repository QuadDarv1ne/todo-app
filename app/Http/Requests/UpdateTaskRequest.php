<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NotPastDate;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Авторизация будет проверяться в политике доступа
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
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:65535',
            'completed' => 'sometimes|boolean',
            'due_date' => ['nullable', 'date', new NotPastDate()],
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
            'completed.boolean' => 'Статус завершения должен быть булевым значением.',
            'due_date.date' => 'Дата выполнения должна быть корректной датой.',
        ];
    }
}