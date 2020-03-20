<?php

namespace DNAFactory\Framework\Api;

class FilterGroup
{
    protected $_filters = [];

    public function setFilters(array $filters): void
    {
        $this->_filters = $filters;
    }

    public function getFilters(): array
    {
        return $this->_filters;
    }

    public function toArray(): array
    {
        $filterGroups = [];
        $filterGroups['filters'] = [];

        foreach ($this->getFilters() as $filter) {
            $filterGroups['filters'][] = $filter->toArray();
        }

        return $filterGroups;
    }
}
