<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchClientRequest extends FormRequest
{
    /**
     * Доступ к поиску клиентов только служебным ролям
     * или пользователям хотябы с 1 рекрутером
     *
     * @return bool
     */
    public function authorize()
    {
        $role = $this->user()->role;
        if ($role == 'accountant' || $role == 'admin' || $role == 'assistant') {
            return true;
        } else {
            return $this->user()->recruiters->isNotEmpty();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'pasport' => ['nullable', 'string']
        ];
    }
}
