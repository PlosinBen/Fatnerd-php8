<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $group
 * @property-read string $period
 * @property-read numeric $commitment
 * @property-read numeric $open_profit
 * @property-read numeric $write_off_profit
 * @property-read numeric $deposit
 * @property-read numeric $withdraw
 */
class InvestFuturesStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'group' => [
                'nullable',
                'string'
            ],
            'period' => [
                'required',
                'date_format:Ym'
            ],
            'commitment' => [
                'required',
                'numeric'
            ],
            'open_profit' => [
                'required',
                'decimal:0,4'
            ],
            'write_off_profit' => [
                'required',
                'numeric'
            ],
            'deposit' => [
                'nullable',
                'numeric'
            ],
            'withdraw' => [
                'nullable',
                'numeric'
            ]
        ];
    }
}
