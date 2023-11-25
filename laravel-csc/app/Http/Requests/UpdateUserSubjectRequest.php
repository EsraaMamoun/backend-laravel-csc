<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subjects_id' => 'numeric',
            'users_id' => 'numeric',
            'mark' => 'numeric'
        ];
    }
}
