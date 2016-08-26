<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetLatestEventsRequest extends FormRequest
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
            // 'since' => 'sometimes|required|alpha_num|between:5,25',
            // 'since' => 'sometimes|required|alpha_num|between:5,25',
        ];
    }
}
