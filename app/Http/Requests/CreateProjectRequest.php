<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'clientCompanyName' => 'required',
            'performerCompanyName' => 'required',
            'startDate' => 'required|date|before:endDate|after:now',
            'endDate' => 'required|date|after:startDate',
            'priority' => 'required|integer',
            'leader_id' => 'required|numeric',
            'performers_id' => 'array',
            'performers_id.*' => 'distinct|numeric'
        ];
    }
}
