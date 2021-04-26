<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserResource extends JsonResource
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
            'user' => [
                'id'          => (int) $this->id,
                'type'        => $this->type,
                'email'       => $this->email,
                'f_name'      => $this->f_name,
                'l_name'      => $this->l_name,
                'phone'       => $this->phone,
                'picture'     => $this->picture,
                'nbi_id'      => $this->nbi_id,
                'dti_id'      => $this->dti_id,
                'api_token'   => $this->api_token,
                'address'   => $this->address,
                'created_at'  => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
                'updated_at'  => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
            ]
        ];
    }
}
