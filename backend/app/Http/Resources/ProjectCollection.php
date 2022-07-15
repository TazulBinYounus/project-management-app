<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'memberNames' => $this->getUserNames(),
        ];
    }

    public function getUserNames(): array
    {
        $users = UserCollection::collection($this->users);
        $userNames = [];
        foreach ($users as $user){
            $userNames[] = ' ' . $user->name;
        }
        return $userNames;
    }

}
