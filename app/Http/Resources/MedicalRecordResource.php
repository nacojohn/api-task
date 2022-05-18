<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'patient' => $this->whenLoaded('patient'),
            'tests' => $this->getTests(),
            'ctscan' => $this->ctscan,
            'mri' => $this->mri,
            'date_added' => $this->created_at->diffForHumans()
        ];
    }
}
