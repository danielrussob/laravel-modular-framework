<?php

namespace DNAFactory\Framework\Factory;

use DNAFactory\Framework\Api\ConfigFactoryInterface;
use DNAFactory\Framework\Api\ConfigRepositoryInterface;
use DNAFactory\Framework\Model\Config;

class ConfigFactory implements ConfigFactoryInterface
{
    protected $_repository;

    public function __construct(
        ConfigRepositoryInterface $repository
    )
    {
        $this->_repository = $repository;
    }

    public function create(string $code, $value, $update = false, array $params = [])
    {
        $config = $this->make($code, $value, $params);
        $this->_repository->save($config, $update);
    }

    public function make(string $code, $value, array $params = [])
    {
        return factory(Config::class)->make(['code' => $code, 'value' => $value]);
    }
}
