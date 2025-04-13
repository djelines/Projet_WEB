<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        // Autoriser l'accès à tous les utilisateurs (ou ajuster selon votre logique)
        return true;
    }

    public function rules()
    {
        return [
            'sort' => 'in:asc,desc',   // Tri ascendant ou descendant
            'sort_by' => 'in:created_at,id', // Tri par date de création ou ID
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

