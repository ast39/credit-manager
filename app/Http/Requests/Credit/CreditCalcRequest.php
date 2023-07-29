<?php

namespace App\Http\Requests\Credit;

use App\Enums\CreditSubjectEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreditCalcRequest extends FormRequest {

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

            'title'        => 'required|string',
            'subject'      => 'required|string',
            'currency_id'  => 'required|integer',
            'amount'       => [
                "required_if:subject, !=, " . CreditSubjectEnum::Amount->value,
                "regex:/^\d+(\.\d{1,2})?$/",
            ],
            'percent'      => [
                "required_if:subject, !=, " . CreditSubjectEnum::Percent->value,
                "regex:/^\d+(\.\d{1,2})?$/",
            ],
            'period'       => [
                "required_if:subject, !=, " . CreditSubjectEnum::Period->value,
                "integer",
            ],
            'payment'      => [
                "required_if:subject, !=, " . CreditSubjectEnum::Payment->value,
                "regex:/^\d+(\.\d{1,2})?$/",
            ],
            'payment_type' => 'required|integer',
        ];
    }
}
