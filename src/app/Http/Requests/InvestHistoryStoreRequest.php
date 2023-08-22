<?php

namespace App\Http\Requests;

use App\Models\InvestAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read int $invest_account
 * @property-read string $deal_at
 * @property-read string $type
 * @property-read numeric $amount
 * @property-read string|null $note
 */
class InvestHistoryStoreRequest extends FormRequest
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
            'invest_account' => [
                'required',
                Rule::exists(
                    InvestAccount::class,
                    InvestAccount::ID
                )
            ],
            'deal_at' => [
                'required',
                'date'
            ],
            'type' => [
                'required',
                Rule::in(
                    array_keys(
                        config('invest.type')
                    )
                )
            ],
            'amount' => [
                'required',
                'numeric'
            ],
            'note' => [
                'nullable',
            ]
        ];
    }
}
