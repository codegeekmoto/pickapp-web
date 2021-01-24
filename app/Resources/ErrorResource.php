<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ErrorResource extends JsonResource {

    /**
       * Transform the resource into an array.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return array
       */
      public function toArray($request)
      {
          return [
            "status" => false,
            "message" => $this->message,
            "errors" => $this->errors
          ];
      }
  
  }