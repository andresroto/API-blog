<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => new UserResource($this->user),
            'category' => new CategoryResource($this->category),
            'id' => $this->id,
            'title' => $this->title, 
            'slug' => $this->slug, 
            'description' => $this->description, 
            'content' => $this->content, 
            'published' => $this->published == 1 ? true : false, 
            'tags' => TagResource::collection($this->tags),
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d-m-Y')
        ]; 
    }
}
