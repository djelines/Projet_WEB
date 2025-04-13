<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // Tout utilisateur peut accéder à cette page (ajuster si nécessaire)
    }

    public function rules()
    {
        // Pas de validation particulière pour "create"
        return [];
    }

    public function messages()
    {
        return [];
    }
}
