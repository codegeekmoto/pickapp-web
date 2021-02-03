<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PasswordResetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ['password_reset' => [
            'id'            => $this->id,
            'email'         => $this->email,
            'code'          => $this->code,
            'token'         => $this->token,
            'created_at'    => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at'    => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
        ]];
    }
}
