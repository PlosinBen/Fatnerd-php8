<?php

namespace App\Http\Resources;

use App\Models\StatementFutures;
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
        return array_merge(parent::toArray($request));
    }
}
