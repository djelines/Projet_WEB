<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        // Authorise access to all users
        return true;
    }

    public function rules()
    {
        return [
            'sort' => 'in:asc,desc',   // Sort ascending or descending
            'sort_by' => 'in:created_at,id', // Sort by creation date or ID
        ];
    }

    public function messages()
    {
        return [
            'sort.in' => 'Le tri doit être "asc" ou "desc".',
            'sort_by.in' => 'Le tri doit être par "created_at" ou "id".',
        ];
    }
}

