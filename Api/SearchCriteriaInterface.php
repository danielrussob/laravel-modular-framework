<?php

namespace DNAFactory\Framework\Api;

use DNAFactory\Framework\Api\Data\LanguageInterface;

interface SearchCriteriaInterface
{
    public function getFilterGroups(): array;

    public function setFilterGroups(array $filterGroups): void;

    public function setSortOrder(array $sortOrder): void;

    public function getSortOrder(): array;

    public function setPageSize($pageSize): void;

    public function getPageSize(): ?int;

    public function setCurrentPage(int $currentPage): void;

    public function getCurrentPage(): ?int;

    public function setLanguageCode(string $code): void;

    public function setLanguage(LanguageInterface $language): void;

    public function getLanguage(): LanguageInterface;

    public function toArray(): array;
}