<?php

namespace DNAFactory\Framework\Api\SearchCriteria;

use DNAFactory\Framework\Api\SearchCriteriaInterface;
use Illuminate\Database\Eloquent\Builder;

interface CollectionProcessorInterface
{
    public function process(SearchCriteriaInterface $searchCriteria, Builder $model);
}