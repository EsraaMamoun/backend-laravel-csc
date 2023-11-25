<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSubjectResource extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'users_id' => $this->users_id,
            'subjects_id' => $this->subjects_id,
            'mark' => $this->mark,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
