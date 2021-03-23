<?php

namespace App\Http\Resources\ATM;

use Illuminate\Http\Resources\Json\JsonResource;

class TestCase extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}
