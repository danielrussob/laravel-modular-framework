<?php

namespace DNAFactory\Framework\Api;

use DNAFactory\Framework\Api\Data\LanguageInterface;
use DNAFactory\Framework\Api\LanguageRepositoryInterface;

class SearchCriteria implements SearchCriteriaInterface
{
    const DEFAULT_PAGESIZE = 100000000;

    protected $_filterGroups = [];
    protected $_sortOrder = [];
    protected $_pageSize = self::DEFAULT_PAGESIZE;
    protected $_currentPage = 1;
    protected $_language = null;

    public function __construct()
    {

    }

    public function getFilterGroups(): array
    {
        return $this->_filterGroups;
    }

    public function setFilterGroups(array $filterGroups): void
    {
        $this->_filterGroups = $filterGroups;
    }

    public function setSortOrder(array $sortOrder): void
    {
        $this->_sortOrder = $sortOrder;
    }

    public function getSortOrder(): array
    {
        return $this->_sortOrder;
    }

    public function setPageSize($pageSize): void
    {
        $this->_pageSize = $pageSize;
    }

    public function getPageSize(): ?int
    {
        return $this->_pageSize;
    }

    public function setCurrentPage(int $currentPage): void
    {
        $this->_currentPage = $currentPage;
    }

    public function getCurrentPage(): ?int
    {
        return $this->_currentPage;
    }

    public function setLanguageCode(string $code): void
    {
        $languageRepository = app()->make(LanguageRepositoryInterface::class);
        $this->_language = $languageRepository->get($code);
    }

    public function setLanguage(LanguageInterface $language): void
    {
        $this->_language = $language;
    }

    public function getLanguage(): LanguageInterface
    {
        if ($this->_language !== null) {
            return $this->_language;
        }

        $languageRepository = app()->make(LanguageRepositoryInterface::class);
        $this->_language = $languageRepository->getDefault();
        return $this->_language;
    }

    public function toArray(): array
    {
        $searchCriteria = [];
        $searchCriteria['filter_groups'] = [];

        foreach ($this->getFilterGroups() as $filterGroup) {
            $searchCriteria['filter_groups'][] = $filterGroup->toArray();
        }

        $searchCriteria['sortOrders'] = [];

        foreach ($this->getSortOrder() as $sortOrder)
        {
            $searchCriteria['sortOrders'][] = $sortOrder->toArray();
        }

        $searchCriteria['pageSize'] = $this->getPageSize();
        $searchCriteria['currentPage'] = $this->getCurrentPage();

        return $searchCriteria;
    }
}
