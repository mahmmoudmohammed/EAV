<?php

namespace App\Http\Domains\EAV\Request;

use App\Http\Domains\EAV\Model\AttributeTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAttributeRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('attributes')->ignore($this->route('id'))],
            'type' => ['required', Rule::in(AttributeTypeEnum::values())],
            'options' => 'required_if:type,select|array',
        ];
    }
}
