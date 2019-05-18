<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RentSearch extends FormRequest
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
        $upper = config("rentsearch.rentUpperLimit");
        $lower = config("rentsearch.rentLowerLimit");

        return [
            'area' => "required|array",
            'area.*' => "integer",
            'rent_lower_limit' => "nullable|integer|between:{$lower},{$upper}",
            'rent_upper_limit' => "nullable|integer|between:{$lower},{$upper}",
            'floor_plan' => "array",
            'floor_plan.*' => "integer",
            'age' => "nullable|integer",
            'option' => "array",
            'option.*' => "integer",
        ];
        // return [
        //     'area' => "required|array",
        //     'area.*' => "integer",
        //     'rent_lower_limit' => "integer|between:{$lower},{$upper}",
        //     'rent_upper_limit' => "integer|between:{$lower},{$upper}",
        //     'floor_plan' => "array",
        //     'floor_plan.*' => "integer",
        //     'age' => "integer",
        //     'option' => "array",
        //     'option.*' => "integer",
        // ];
    }
}
