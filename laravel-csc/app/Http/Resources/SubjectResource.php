<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'subject_name' => $this->subject_name,
            'minimum_mark' => $this->minimum_mark,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
