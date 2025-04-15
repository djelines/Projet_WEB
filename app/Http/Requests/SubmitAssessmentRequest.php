<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAssessmentRequest extends FormRequest
{
    public function authorize()
    {
       
        return true;
    }

    public function rules()
    {
        return [
            'answers' => 'required|array',
            'answers.*' => 'required|string',  // Must be string
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

