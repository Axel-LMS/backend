<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'couse_id' => $this->course_id,
            'cycle_id' => $this->cycle_id,
            'classNo' => $this->classNo,
            'student' => $this->student->name,
            'timeArrive' => $this->timeArrive,
            'timeLeave' => $this->timeLeave,
            'created_at' => $this->created_at->format('d-m-y'),
            'updated_at' => $this->updated_at->format('d-m-Y')
        ];
    }
}
