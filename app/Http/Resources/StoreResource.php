<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class StoreResource extends JsonResource
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
            'store' => [
                'id'                => (int) $this->id,
                'seller_id'         => $this->seller_id,
                'dti'               => $this->dti,
                'name'              => $this->name,
                'description'       => $this->description,
                'business_permit'   => $this->business_permit,
                'address'           => $this->address,
                'location'          => $this->location,
                'created_at'        => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
                'updated_at'        => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
            ]
        ];
    }
}
