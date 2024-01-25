<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'table_id' => $this->table_id,
            'customer_id' => $this->customer_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'guest_count' => $this->guest_count,
            'status' => $this->status,
        ];
    }
}
