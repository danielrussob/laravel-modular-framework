<?php

namespace DNAFactory\Framework\Model;

use App\Eav\Model\Attribute\Set;
use App\Eav\Model\Attribute\Value;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

abstract class EavModel extends Model
{
    /** @var Set  */
    protected $_attributeSet = null;

    protected $_languageId = null;

    /**
     * @var array $eavAttributes list of eavAttributes as string (ex: name, short_description, ...)
     *              mapped by attributeSetId, leave static for performance
     */
    protected static $eavAttributes;
    protected static $eavAttributesBuilded;

    /**
     * @var array $eavAttributes list of eavAttributes as \App\Eav\Model\Attribute
     *              mapped by attributeSetId, leave static for performance
     */
    protected static $eavRawAttributes;

    /**
     * @var array $eavAttributes list of eavAttributes as \App\Eav\Model\Attribute\Value
     */
    protected $eavRawAttributeValues = [];

    protected $bufferedEavAttributeValues = [];

    /**
     * @return BelongsTo Relation belongsTo with attribute set
     */
    abstract function attributeSet() : BelongsTo;

    /**
     * @return string foreing key used
     *              in \App\Eav\Model\Attribute\Value\Varchar::TABLE (eav_attribute_value_varchars)
     */
    abstract function getForeign() : string;

    public static function boot()
    {
        parent::boot();
        static::retrieved(function ($model) {
            $model->reloadAttributes();
        });
    }

    public function setLanguageId($languageId) : EavModel
    {
        $this->_languageId = $languageId;
        $this->reloadAttributes();
        return $this;
    }

    public function reloadAttributes($force = false) : EavModel
    {
        if ($force) {
            self::$eavAttributesBuilded = false;
        }

        self::buildEavAttributes();
        $this->buildEavAttributeValues();
        return $this;
    }

    public static function buildEavAttributes() : bool
    {
        if (self::$eavAttributesBuilded === true) {
            return false;
        }

        self::$eavAttributes = [];
        self::$eavRawAttributes = [];

        foreach (Set::all() as $attributeSet) {

            self::$eavAttributes[$attributeSet->getKey()] = [];
            self::$eavRawAttributes[$attributeSet->getKey()] = [];

            foreach ($attributeSet->allAttributes as $attribute) {
                self::$eavAttributes[$attributeSet->getKey()][] = $attribute->code;
                self::$eavRawAttributes[$attributeSet->getKey()][] = $attribute;
            }

        }

        return true;
    }

    protected function buildEavAttributeValues() : void
    {
        // TODO: optimize multilanguage, saving eavRawAttributeValues as array mapped by languageId
        $attributeSet = $this->_getAttributeSet();

        foreach (self::$eavRawAttributes[$attributeSet->getKey()] as $eavRawAttribute) {
            $eavRawAttribute->setForeignEavName($this->getForeign());
            $value = $eavRawAttribute->getValueInstance($this->id, $this->getForeign(), $this->_languageId);
            $this->attributes[$eavRawAttribute->code] = $value->value;
            $this->eavRawAttributeValues[$eavRawAttribute->code] = $value;
        }
    }

    public static function getAllAttributeCodes() : array
    {
        self::buildEavAttributes();

        $tmp = [];
        foreach (self::$eavRawAttributes as $eavRawAttributes) {
            foreach ($eavRawAttributes as $eavRawAttribute) {
                if (!in_array($eavRawAttribute->code, $tmp)) {
                    $tmp[] = $eavRawAttribute->code;
                }
            }
        }

        return $tmp;
    }

    public function getAttributesCode() : array
    {
        $attributeSet = $this->_getAttributeSet();
        return self::$eavAttributes[$attributeSet->getKey()];
    }

    public function _getAttributeSet() : Set
    {
        if ($this->_attributeSet === null) {
            $this->_attributeSet = $this->attributeSet;
        }

        return $this->_attributeSet;
    }

    public function saveEavAttributes()
    {
        foreach ($this->eavRawAttributeValues as $eavRawAttributeValue) {
            $eavRawAttributeValue->save();
        }
    }

    public function bufferizeEavAttributeValues()
    {
        self::buildEavAttributes();
        $attributeSet = $this->_getAttributeSet();

        if (array_key_exists($attributeSet->getKey(), self::$eavAttributes)) {
            foreach (self::$eavAttributes[$attributeSet->getKey()] as $eavAttribute) {
                if (array_key_exists($eavAttribute, $this->attributes)) {
                    $this->bufferedEavAttributeValues[$eavAttribute] = $this->attributes[$eavAttribute];
                    unset($this->attributes[$eavAttribute]);
                }
            }
        }
    }

    public function unbufferizeEavAttributeValues()
    {
        foreach ($this->bufferedEavAttributeValues as $key => $value) {
            $this->__set($key, $value);
        }

        $this->bufferedEavAttributeValues = [];
    }

    public function save(array $options = []) : bool
    {
        $this->saveEavAttributes();

        $this->bufferizeEavAttributeValues();

        $saveResult = parent::save($options);

        $this->unbufferizeEavAttributeValues();

        return $saveResult;
    }

    public function __get($key)
    {
        return parent::__get($key);
    }

    public function __setEav($key, $value)
    {
        $attributeSet = $this->_getAttributeSet();

        if (!array_key_exists($attributeSet->getKey(), self::$eavAttributes)) {
            return false;
        }

        if (!in_array($key, self::$eavAttributes[$attributeSet->getKey()])) {
            return false;
        }

        $this->eavRawAttributeValues[$key]->value = $value;
        return true;
    }

    public function __set($key, $value)
    {
        $this->__setEav($key, $value);
        parent::__set($key, $value);
    }
}
