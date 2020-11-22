<?php

namespace App\Http\Resources\Takeed\Election;

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
        if($this->gender ==1)
        {
        return [
            $this->family_name,
            $this->name,
            $this->first_name,
            $this->second_name,
            $this->third_name,
            $this->forth_name,
            $this->area->title,
            'رجل',
            $this->internal_reference,
            $this->civil_reference,
            $this->birth_day,
            $this->job,
            $this->address,
            $this->registration_status,
            $this->registration_number,
            $this->registration_data,
            $this->circle->title
        ];
        }else
        {
            return [
                $this->family_name,
                $this->name,
                $this->first_name,
                $this->second_name,
                $this->third_name,
                $this->forth_name,
                $this->area->title,
               "انثي",
                $this->internal_reference,
                $this->civil_reference,
                $this->birth_day,
                $this->job,
                $this->address,
                $this->registration_status,
                $this->registration_number,
                $this->registration_data,
                $this->circle->title
            ];
        }
    }
}
