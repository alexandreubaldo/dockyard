<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class YardUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $min_width = config('constants.container.width');
        $min_length = config('constants.container.length');

        return [
            'locator' => ['required', 'unique:App\Models\Yard,locator,' . $this->yard->id, 'size:3'],
            'width' => ['integer','required', "min:$min_width"],
            'length' => ['integer', 'required', "min:$min_length"]
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->yard->area > $this->width * $this->length) {
                $validator->errors()->add('area', 'You can not decrease the yard area');
            }
        });
    }
}
