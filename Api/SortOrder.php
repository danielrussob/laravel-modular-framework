<?php

namespace DNAFactory\Framework\Api;

class SortOrder
{
    protected $_field = null;
    protected $_direction = null;

    const SORT_ASC = 'ASC';
    const SORT_DESC = 'DESC';
    const SORT_DEFAULT = self::SORT_ASC;

    /**
     * @return mixed
     */
    public function getField(): ?string
    {
        return $this->_field;
    }

    /**
     * @param mixed $field
     */
    public function setField(string $field): void
    {
        $this->_field = $field;
    }

    /**
     * @return mixed
     */
    public function getDirection(): ?string
    {
        return $this->_direction;
    }

    /**
     * @param mixed $direction
     */
    public function setDirection(string $direction): void
    {
        $this->_direction = $direction;
    }

    public function toArray(): array
    {
        return [
            'field' => $this->getField(),
            'direction' => $this->getDirection(),
        ];
    }
}
