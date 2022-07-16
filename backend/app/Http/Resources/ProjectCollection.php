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
            'group' => $this->group,
            'memberNames' => $this->getUserNames(),
            'created_at' => date('d-M-Y', strtotime($this->created_at)),
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
