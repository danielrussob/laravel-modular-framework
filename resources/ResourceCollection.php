<?php

namespace DNAFactory\Framework\resources;

use Illuminate\Http\Resources\Json\JsonResource as IlluminateJsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection as IlluminateResourceCollection;

class ResourceCollection extends IlluminateResourceCollection
{
    public $preserveKeys = true;

     public function __construct($resource, $status, string $message)
     {
         parent::__construct($resource);
         $this->additional(array("status" => $status, "message" => __($message)));
     }

     public static function collection($resource, $status = 1, string $message = "Operazione avvenuta con successo")
     {
         $response = parent::collection($resource);
         $response->additional(array("status" => $status, "message" => __($message)));
         return $response;
     }
}
