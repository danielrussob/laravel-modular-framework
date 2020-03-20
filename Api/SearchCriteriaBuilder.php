<?php

namespace DNAFactory\Framework\Api;

use DNAFactory\Framework\Api\Data\LanguageInterface;
use Illuminate\Http\Request;

class SearchCriteriaBuilder
{
    /** @var SearchCriteriaInterface */
    protected $_searchCriteria;

    /** @var Request */
    protected $_request;

    protected $_filterGroup = [];

    public function __construct(SearchCriteriaInterface $searchCriteria, Request $request)
    {
        $this->_searchCriteria = $searchCriteria;
        $this->_request = $request;
    }

    public function create(): SearchCriteriaInterface
    {
        return $this->_searchCriteria;
    }

    public static function all(): SearchCriteriaInterface
    {
        return app()->make(SearchCriteriaInterface::class);
    }

    public function setPageSize($pageSize): SearchCriteriaBuilder
    {
        $this->_searchCriteria->setPageSize($pageSize);
        return $this;
    }

    public function setCurrentPage($currentPage): SearchCriteriaBuilder
    {
        $this->_searchCriteria->setCurrentPage($currentPage);
        return $this;
    }

    public function addSortOrder(string $field, string $direction = SortOrder::SORT_DEFAULT): SearchCriteriaBuilder
    {
        $this->addSortOrders([['field' => $field, 'direction' => $direction]]);
        return $this;
    }

    public function addSortOrders(array $sortOrderValues): SearchCriteriaBuilder
    {
        $sortOrders = [];

        foreach ($sortOrderValues as $sortOrderValue) {
            /** @var SortOrder $sortOrder */
            $sortOrder = app()->make(SortOrder::class);
            $sortOrder->setField($sortOrderValue['field']);
            if (!array_key_exists('direction', $sortOrderValue)) {
                $sortOrderValue['direction'] = SortOrder::SORT_DEFAULT;
            }
            $sortOrder->setDirection($sortOrderValue['direction']);
            $sortOrders[] = $sortOrder;
        }

        $buffer = $this->_searchCriteria->getSortOrder();
        $buffer = array_merge($sortOrders, $buffer);
        $this->_searchCriteria->setSortOrder($buffer);

        return $this;
    }

    public function addFilter($field, $value, $conditionType = '='): SearchCriteriaBuilder
    {
        $this->addFilters([['field' => $field, 'value' => $value, 'condition_type' => $conditionType]]);
        return $this;
    }

    public function addFilters(array $filterValues): SearchCriteriaBuilder
    {
        /** @var FilterGroup $filterGroup */
        $filterGroup = app()->make(FilterGroup::class);
        $filters = [];

        foreach ($filterValues as $filterValue) {
            /** @var Filter $filter */
            $filter = app()->make(Filter::class);
            $filter->setField($filterValue['field']);
            $filter->setValue($filterValue['value']);
            if (!array_key_exists('condition_type', $filterValue)) {
                $filterValue['condition_type'] = '=';
            }
            $filter->setConditionType($filterValue['condition_type']);

            $filters[] = $filter;
        }

        $filterGroup->setFilters($filters);

        $buffer = $this->_searchCriteria->getFilterGroups();
        $buffer[] = $filterGroup;
        $this->_searchCriteria->setFilterGroups($buffer);

        return $this;
    }

    public function setLanguageCode(string $code): void
    {
        $this->_searchCriteria->setLanguageCode($code);
    }

    public function setLanguage(LanguageInterface $language): void
    {
        $this->_searchCriteria->setLanguage($language);
    }

    public function getLanguage(): LanguageInterface
    {
        return $this->_searchCriteria->getLanguage();
    }

    public function buildFromArray($array)
    {
        if (array_key_exists('pageSize', $array)) {
            $this->setPageSize($array['pageSize']);
        }

        if (array_key_exists('currentPage', $array)) {
            $this->setCurrentPage($array['currentPage']);
        }

        if (array_key_exists('sortOrders', $array)) {
            $this->addSortOrders($array['sortOrders']);
        }

        if (array_key_exists('filter_groups', $array)) {
            foreach ($array['filter_groups'] as $filterGroups) {
                foreach ($filterGroups as $filters) {
                    $this->addFilters($filters);
                }
            }
        }

        return $this;
    }

    public function buildFromHttp()
    {
        $searchCriteria = $this->_request->get('searchCriteria', null);
        if ($searchCriteria === null) {
            return $this;
        }

        $this->buildFromArray($searchCriteria);

        return $this;
    }
}