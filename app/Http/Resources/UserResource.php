<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Company;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' =>$this->role,
            'company' =>    $this->company_id,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
