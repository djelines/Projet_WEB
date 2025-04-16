<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // Any user can access this page 
    }

    public function rules()
    {
        // No particular validation required for "create
        return [];
    }

    public function messages()
    {
        return [];
    }
}
