<?php

namespace App\Http\Resources\Takeed\ACL;

use Illuminate\Http\Resources\Json\JsonResource;

class TakeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            $this->family_name,
            $this->name,
            $this->first_name,
            $this->second_name,
            $this->third_name,
            $this->forth_name,
            $this->family_name_one,
            $this->table_area,
            $this->table_gender,
            $this->internal_reference,
            $this->civil_reference,
            $this->birth_day,
            $this->job,
            $this->address,
            $this->registration_status,
            $this->registration_number,
            $this->registration_data,
            $this->circle
        ];
    }
}
