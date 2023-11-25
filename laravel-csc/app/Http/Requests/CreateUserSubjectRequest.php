<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'subjects_id' => 'required|numeric',
            'users_id' => 'required|numeric',
            'mark' => 'numeric'
        ];
    }
}
