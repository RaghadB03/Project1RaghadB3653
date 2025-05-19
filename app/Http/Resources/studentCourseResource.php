<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class studentCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'studentName'  => $this->student->name,
            'studentNo'    => $this->student->no,
            'courseName'   => $this->course->name,
            'courseSymbol' => $this->course->symbol,
            'mark'         => $this->mark,
        ];
    }
}
