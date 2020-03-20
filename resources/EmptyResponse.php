<?php

namespace DNAFactory\Framework\resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmptyResponse extends JsonResource
{
    public function __construct(int $status = 1, string $message = "Operazione avvenuta con successo!", array $params = [])
    {
        $this->additional(array("status" => $status, "message" => __($message), "params" => $params));
    }

    /**
    * Transform the resource into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function toArray($request)
    {
            return [];
    }
}
