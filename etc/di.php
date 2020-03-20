<?php

use DNAFactory\Framework\Api\ConfigFactoryInterface;
use DNAFactory\Framework\Api\ConfigRepositoryInterface;
use DNAFactory\Framework\Api\Data\ConfigInterface;
use DNAFactory\Framework\Factory\ConfigFactory;
use DNAFactory\Framework\Model\Config;
use DNAFactory\Framework\Repository\ConfigRepository;
use DNAFactory\Framework\Api\SearchCriteria;
use DNAFactory\Framework\Api\SearchCriteriaInterface;
use DNAFactory\Framework\Model\Log;

use Psr\Log\LoggerInterface;

return [
    'bind' => [
        LoggerInterface::class => Log::class,

        SearchCriteriaInterface::class => SearchCriteria::class,
        SearchCriteria\CollectionProcessorInterface::class => SearchCriteria\CollectionProcessor::class,

        ConfigInterface::class => Config::class,
        ConfigRepositoryInterface::class => ConfigRepository::class,
        ConfigFactoryInterface::class => ConfigFactory::class
    ],

    'singleton' => [

    ]
];
