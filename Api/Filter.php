<?php

namespace DNAFactory\Framework\Api;

class Filter
{
    protected $_value = null;
    protected $_field = null;
    protected $_conditionType = null;

    protected $_proxyConditionType = [
        '=' => '=',
        'eq' => '=',
        '!=' => '<>',
        'neq' => '<>',
        '<>' => '<>',
        'like' => 'like',
        'nlike' => 'nlike',
        'in' => 'in',
        'nin' => 'nin',
        'null' => 'null',
        'notnull' => 'notnull',
        '>' => '>',
        'gt' => '>',
        '<' => '<',
        'lt' => '<',
        '>=' => '>=',
        'gteq' => '>=',
        '<=' => '<=',
        'lteq' => '<='
    ];

    public function getField(): ?string
    {
        return $this->_field;
    }

    public function setField(string $field): void
    {
        $this->_field = $field;
    }

    public function getConditionType(): ?string
    {
        return $this->_conditionType;
    }

    public function setConditionType(string $conditionType): void
    {
        $this->_conditionType = $this->_proxyConditionType[$conditionType];
    }

    public function getValue(): ?string
    {
        return $this->_value;
    }

    public function setValue(string $value): void
    {
        $this->_value = $value;
    }

    public function toArray(): array
    {
        return [
            'field' => $this->getField(),
            'value' => $this->getValue(),
            'condition_type' => $this->getConditionType()
        ];
    }
}
