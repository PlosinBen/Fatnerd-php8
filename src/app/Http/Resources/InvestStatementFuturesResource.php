<?php

namespace App\Http\Resources;

use App\Models\InvestStatementFutures;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestStatementFuturesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var InvestStatementFutures $this
         */
        return [
            'id' => $this->id,
            'period' => $this->period->format('Ym'),
            'group' => $this->group,
            'commitment' => $this->commitment,
            'open_profit' => $this->open_profit,
            'write_off_profit' => $this->write_off_profit,
            'deposit' => $this->deposit,
            'withdraw' => $this->withdraw,
            'real_commitment' => $this->real_commitment,
            'commitment_profit' => $this->commitment_profit,
            'profit' => $this->profit,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}
