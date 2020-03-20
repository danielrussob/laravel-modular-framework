<?php

namespace DNAFactory\Framework\Api;

use DNAFactory\Framework\Api\Data\ConfigInterface;
use DNAFactory\Framework\Api\SearchCriteriaInterface;
use Illuminate\Support\Collection;

interface ConfigRepositoryInterface
{
    public function save(ConfigInterface $config, $update = false): ConfigInterface;

    public function get(string $code): ConfigInterface;

    public function getById(int $id): ConfigInterface;

    public function delete(ConfigInterface $config): ?bool;

    public function deleteById(int $id): ?bool;

    public function deleteByCode(string $code): ?bool;

    public function getList(SearchCriteriaInterface $searchCriteria) : Collection;
}
