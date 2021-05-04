<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Support\Carbon;

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
        return [
            'product' => [
                'id'                => (int) $this->id,
                'store_id'          => $this->store_id,
                'category_id'       => $this->category_id,
                'name'              => $this->name,
                'description'       => $this->description,
                'price'             => $this->price,
                'num_of_stock'      => $this->num_of_stock,
                'created_at'        => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
                'updated_at'        => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
            ]
        ];
    }
}
