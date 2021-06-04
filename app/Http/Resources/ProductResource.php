<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => (int) $this->id,
            'nombre' => (string) $this->name,
            'precio' => (float) $this->price,
            'categoria' =>  $this->category,
            'user_rating' => $this->averageRating(User::class),
            'image' => $this->image_url,
            'creado_por' =>  $this->createdBy->name,
        ];
    }
}
