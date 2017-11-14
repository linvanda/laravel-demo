<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'super' => $this->when($this->isAdmin(), 1),
            $this->mergeWhen($this->isAdmin(), [
                'super_name' => 'zhang san',
                'super_id' => 34
            ]),
            'followers' => User::collection($this->whenLoaded('followers'))
        ];
    }

    public function with($request)
    {
        return [
            'meta' => [
                'myu_k' => 'mm'
            ]
        ];
    }
}
