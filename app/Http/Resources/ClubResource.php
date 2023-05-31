<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClubResource extends JsonResource
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
            'course_id' => $this->course_id,
            'cycle_id' => $this->cycle_id,
            'classNo' => $this->classNo,
            'teacher' => $this->teacher->name,
            'classTitle' => $this->classTitle,
            'classDate' => $this->classDate,
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y')
        ];
    }
}
