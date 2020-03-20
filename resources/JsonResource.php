<?php

namespace DNAFactory\Framework\resources;

use Illuminate\Http\Resources\Json\JsonResource as IlluminateJsonResource;

class JsonResource extends IlluminateJsonResource
{
    public $preserveKeys = true;

    public function __construct($resource, $status, string $message)
    {
        parent::__construct($resource);
        $this->additional(array("status" => $status, "message" => $message));
    }

    public static function collection($resource, $status = 1, string $message = "Operazione avvenuta con successo")
    {
        $response = parent::collection($resource);
        $response->additional(array("status" => $status, "message" => __($message)));
        return $response;
    }
}
