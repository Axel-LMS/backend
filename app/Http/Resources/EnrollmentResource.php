<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
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
            'id' => $this->id,
            'course' => $this->course->description,
            'cycle' => $this->cycle->description,
            'student' => $this->student->email,
            'enrollmentDate' =>$this->enrollmentDate,
            'cancelled' => $this->cancelled,
            'cancellationReason' => $this->cancellationReason,
            'created_at' => $this->created_at->format('d-m-y'),
            'updated_at' => $this->updated_at->format('d-m-y'),
        ];
    }
}
