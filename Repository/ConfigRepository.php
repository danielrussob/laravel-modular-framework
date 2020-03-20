<?php

namespace DNAFactory\Framework\Repository;

use DNAFactory\Framework\Api\ConfigRepositoryInterface;
use DNAFactory\Framework\Api\Data\ConfigInterface;
use DNAFactory\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use DNAFactory\Framework\Api\SearchCriteriaInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class ConfigRepository implements ConfigRepositoryInterface
{
    protected $_config;
    protected $_collectionProcessor;

    public function __construct(
        ConfigInterface $config,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->_config = $config;
        $this->_collectionProcessor = $collectionProcessor;
    }

    public function save(ConfigInterface $config, $update = false): ConfigInterface
    {
        try {
            $config->save();
        } catch (QueryException $queryException) {
            if (!$update) {
                throw new \Exception(__("Il codice: :code per la config è già esistente", ['code' => $config->code]));
            }
            $oldConfig = $this->get($config->code);
            $oldConfig->value = $config->value;
            $oldConfig->save();
        }

        return $config;
    }

    public function get(string $code): ConfigInterface
    {
        return $this->_config->where('code', $code)->firstOrFail();
    }

    public function getById(int $id): ConfigInterface
    {
        return $this->_config->findOrFail($id);
    }

    public function delete(ConfigInterface $config): ?bool
    {
        if ($config->system) {
            throw new \Exception(__("La configurazione :code è di sistema e non può essere eliminata", ['code' => $config->code]));
        }

        return $config->delete();
    }

    public function deleteById(int $id): ?bool
    {
        $config = $this->getById($id);
        return $this->delete($config);
    }

    public function deleteByCode(string $code): ?bool
    {
        $config = $this->get($code);
        return $this->delete($config);
    }

    public function getList(SearchCriteriaInterface $searchCriteria): Collection
    {
        $list = $this->_config->newQuery();
        $this->_collectionProcessor->process($searchCriteria, $list);

        return $list->get();
    }
}
