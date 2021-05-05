<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRoom extends CreateRoom
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = parent::rules();

        return $rule;
    }

    public function attributes()
    {
        $attributes = parent::attributes();

        return $attributes;
    }
}
