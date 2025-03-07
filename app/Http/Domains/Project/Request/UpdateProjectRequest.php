<?php

namespace App\Http\Domains\Project\Request;

use App\Http\Domains\Project\Model\ProjectStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'status' => ['sometimes','required', Rule::in(ProjectStatusEnum::values())],
            'user_ids' => 'sometimes|array',
            'user_ids.*' => 'exists:users,id',
            'attributes' => 'sometimes|array',
        ];
    }
}
