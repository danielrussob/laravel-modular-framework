<?php

namespace DNAFactory\Framework\Api\SearchCriteria;

use DNAFactory\Framework\Model\Language;
use App\Eav\Model\Attribute;
use DNAFactory\Framework\Api\Filter;
use DNAFactory\Framework\Api\FilterGroup;
use DNAFactory\Framework\Api\SearchCriteriaInterface;
use DNAFactory\Framework\Model\EavModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CollectionProcessor implements CollectionProcessorInterface
{
    public function process(SearchCriteriaInterface $searchCriteria, Builder $builder)
    {
        $model = $builder->make();
        if ($model instanceof EavModel) {
            $this->buildEav($builder, $model, $searchCriteria);
        }

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            /** @var FilterGroup $filterGroup */

            $orFilter = [];

            foreach ($filterGroup->getFilters() as $filter) {
                /** @var Filter $filter */
                $orFilter[] = $filter->toArray();

            }

            $builder->where(function(Builder $builder) use ($orFilter) {
                foreach ($orFilter as $filter) {
                    $builder->orWhere($filter['field'], $filter['condition_type'], $filter['value']);
                }
            });
        }

        $builder->take($searchCriteria->getPageSize());
        $builder->skip($searchCriteria->getPageSize() * ($searchCriteria->getCurrentPage() - 1));
        foreach ($searchCriteria->getSortOrder() as $sortOrder) {
            $builder->orderBy($sortOrder->getField(), $sortOrder->getDirection());
        }
    }

    public function buildEav(Builder $builder, $model, $searchCriteria)
    {
        $languageId = $searchCriteria->getLanguage()->getKey();

        /** @var EavModel $model */
        $attributeCodes = $model->getAllAttributeCodes();

        foreach ($attributeCodes as $attributeCode) {
            $attribute = $this->getAttributeFromAttributeCode($model::ENTITY_TYPE_ID, $attributeCode);

            if (!$attribute) continue;

            $tableName = $attribute->getValueTableName();

            $asTableName = 'eav_value_table_' . $attributeCode;

            /** @var Builder $attributeBuilder */
            $attributeBuilder = DB::table($tableName)
                ->select(DB::raw($model::FOREIGN . " as ext_id, value as " . $attributeCode))
                ->where('eav_attribute_id', $attribute->getKey())
                ->where(Language::FOREIGN, $languageId);

            $builder->joinSub($attributeBuilder, $asTableName, function ($join) use ($asTableName, $model) {
                $join->on($model::TABLE . '.id', '=', $asTableName . '.ext_id');
            });
        }
    }

    protected function getAttributeFromAttributeCode($entityTypeId, $attributeCode)
    {
        // TODO: to implement cache system
        $attribute = app()->make(Attribute::class);
        $attribute = $attribute->where('code', $attributeCode)->where('eav_entity_id', $entityTypeId)->first();

        return $attribute;
    }
}
