<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        // Autoriser l'accès à tous les utilisateurs (ou ajuster selon votre logique)
        return true;
    }

    public function rules()
    {
        return [
            'answers' => 'required|array',
            'answers.*' => 'required|string',  // Chaque réponse doit être une chaîne de caractères
        ];
    }

    public function messages()
    {
        return [
            'answers.required' => 'Les réponses sont obligatoires.',
            'answers.*.required' => 'Chaque réponse doit être remplie.',
        ];
    }
}

