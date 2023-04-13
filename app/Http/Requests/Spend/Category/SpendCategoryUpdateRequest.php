<?php

namespace App\Http\Requests\Spend\Category;

use Illuminate\Foundation\Http\FormRequest;

class SpendCategoryUpdateRequest extends FormRequest {

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

            'title' => 'string|unique:spending_categories,title,' . $this->id . ',category_id',
        ];
    }
}
