<?php

namespace App\Http\Requests;

use App\Models\Yard;
use App\Rules\MatchValue;
use Illuminate\Foundation\Http\FormRequest;

class ContainerCreateRequest extends FormRequest
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
        return [
            'locator' => ['required', 'size:3', 'regex:/[A-Z]{1}[0-9]{2}/', 'unique:App\Models\Container,locator'],
            'length' => ['required', 'integer', new MatchValue(config('constants.container.length'))],
            'width' => ['required', 'integer', new MatchValue(config('constants.container.width'))],
            'height' => ['required', 'integer', new MatchValue(config('constants.container.height'))],
            'max_load_weight' => ['required', 'integer', new MatchValue(config('constants.container.max_load_weight'))],
            'tare_weight' => ['required', 'integer', new MatchValue(config('constants.container.tare_weight'))],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $yard = Yard::find($this->yard_id);
            if($yard->container_free_capacity <= 0)
            {
                $validator->errors()->add('no_free_area', 'There are no free area to store containers in this Yard');
            }
        });
    }
}
