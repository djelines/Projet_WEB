<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssessmentRequest extends FormRequest
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
    public function rules()
    {
        return [
            'languages' => 'required|array|min:1',
            'num_questions' => 'required|integer|min:1|max:20',
            'cohort_id' => 'required|exists:cohorts,id',
            'num_answers' => 'required|integer|min:2|max:6',
        ];
    }

    public function messages()
    {
        return [
            'languages.required' => 'Les langages sont obligatoires.',
            'num_questions.required' => 'Le nombre de questions est requis.',
            'num_answers.required' => 'Le nombre de réponses est requis.',
            // Ajouter d'autres messages personnalisés si nécessaire
        ];
    }
}
