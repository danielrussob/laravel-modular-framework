<?php

namespace DNAFactory\Framework\Api;

interface ConfigFactoryInterface
{
    public function create(string $code, $value, $update = false, array $params = []);
    public function make(string $code, $value, array $params = []);
}
