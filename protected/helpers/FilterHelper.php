<?php

class FilterItem
{
    private $key;
    private $field;
    private $parameterName;
    private $subQuery;
    private $counter;
    private $query;
    private $parameters;

    public function __construct($key, $field, $parameterName, $subQuery = false)
    {
        $this->key = $key;
        $this->field = $field;
        $this->parameterName = $parameterName;
        $this->subQuery = $subQuery;
        $this->counter = 0;
        $this->parameters = array();
    }

    public function combine($values)
    {
        foreach ($values as $value) {
            $this->formQueryParams($value);
        }

        $this->closeQuery();
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getParameterName()
    {
        return $this->parameterName;
    }

    public function hasQuery()
    {
        return strlen($this->query) > 0;
    }

    public function hasParameters()
    {
        return count($this->parameters) > 0;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    private function formQueryParams($value)
    {
        if (strlen($this->query) == 0) { // ------------------- start
            $this->query .= $this->subQuery ?
                "({$this->field}={$this->parameterName}))" : // ---- (f=(SELECT * FROM tbl WHERE(tbl.f=:parameter))
                "({$this->field}={$this->parameterName}"; // ------- (f=:parameter

            $this->parameters[$this->parameterName] = $value;
        } else {
            $this->counter++;
            $this->query .= $this->subQuery ?
                " OR {$this->field}={$this->parameterName}{$this->counter}))" :
                " OR {$this->field}={$this->parameterName}{$this->counter}";

            $this->parameters[$this->parameterName . $this->counter] = $value;
        }
    }

    private function closeQuery()
    {
        if ($this->getQuery()) {
            $this->query .= ')';
        }
    }
}

class FilterHelper
{
    const BrandFilterParameterName = 'br'; // -------- in request query string
    const BrandFieldName = 'brand_id'; // ------------ in database
    const BrandQueryParameterName = ':brand'; // ----- name for CDbCriteria parameter

    const ColorFilterParameterName = 'cl';
    const ColorFieldName = 'color';
    const ColorQueryParameterName = ':color';

    const SizeFilterParameterName = 'sz';
    const SizeFieldName = 'size_type';
    const SizeQueryParameterName = ':size';

    const CategoryFilterParameterName = 'ct';
    const CategoryFieldName = 'category_id';
    const CategoryQueryParameterName = ':category';

    const SellerFilterParameterName = 'sl';
    const SellerFieldName = 'user_id IN (SELECT `user_id` FROM `seller_profile` WHERE(`seller_type`';
    const SellerQueryParameterName = ':seller';

    const ConditionFilterParameterName = 'cn';
    const ConditionFieldName = '`condition`';
    const ConditionQueryParameterName = ':condition';

    const FilterStringBegin = 'filter';
    const CriteriaDefaultCondition = 'id < 0'; // ---- if condition is empty

    private static $unvalidKeys = array(
        'filter'
    );

    public static function getCriteria($queryString, $additionalWhere = '', $orderBy = '', $limit = 0, $offset = 0)
    {
        $sort = self::sortFilterParameters($queryString);

        return self::getDbCriteria($sort, $additionalWhere, $orderBy, $limit, $offset);
    }

    public static function removeItem($queryString, $key, $value)
    {
        $parameters = self::sortFilterParameters($queryString);

        if (!isset($parameters[$key])) return $queryString;

        if (!in_array($value, $parameters[$key])) return $queryString;

        $parameters[$key] = array_diff($parameters[$key], array($value));

        $resultStr = self::FilterStringBegin;

        foreach ($parameters as $key => $values) {
            foreach ($values as $value) {
                $resultStr .= '/' . $key . '/' . $value;
            }
        }

        return $resultStr;
    }

    public static function removeAllItems($queryString, $key)
    {
        $parameters = self::sortFilterParameters($queryString);

        if (!isset($parameters[$key])) return $queryString;

        unset($parameters[$key]);

        $resultStr = self::FilterStringBegin;

        foreach ($parameters as $key => $values) {
            foreach ($values as $value) {
                $resultStr .= '/' . $key . '/' . $value;
            }
        }

        return $resultStr;
    }

    private static function getDbCriteria($sort, $additionalWhere, $orderBy = '', $limit = 0, $offset = 0)
    {
        $criteria = new CDbCriteria();

        $items = array(
            new FilterItem(self::BrandFilterParameterName, self::BrandFieldName, self::BrandQueryParameterName),
            new FilterItem(self::ColorFilterParameterName, self::ColorFieldName, self::ColorQueryParameterName),
            new FilterItem(self::SizeFilterParameterName, self::SizeFieldName, self::SizeQueryParameterName),
            new FilterItem(self::CategoryFilterParameterName, self::CategoryFieldName, self::CategoryQueryParameterName),
            new FilterItem(self::SellerFilterParameterName, self::SellerFieldName, self::SellerQueryParameterName, true),
            new FilterItem(self::ConditionFilterParameterName, self::ConditionFieldName, self::ConditionQueryParameterName)
        );

        foreach ($items as $item) {
            if (array_key_exists($item->getKey(), $sort)) {
                $item->combine($sort[$item->getKey()]);
            }
        }

        $condition = self::mergeFilterItemsQuery($items);
        if ($condition) {
            $condition .= $additionalWhere ? (' AND (' . $additionalWhere . ')') : '';
        } else {
            $condition .= $additionalWhere;
        }

        $criteria->order = $orderBy;
        $criteria->limit = (int)$limit;
        $criteria->offset = (int)$offset;
        $criteria->condition = $condition ? $condition : self::CriteriaDefaultCondition;
        $criteria->params = self::mergeFilterItemsParams($items);

        return $criteria;
    }

    public static function sortFilterParameters($queryString)
    {
        $sort = array(
            self::BrandFilterParameterName => array(),
            self::ColorFilterParameterName => array(),
            self::SizeFilterParameterName => array(),
            self::CategoryFilterParameterName => array(),
            self::SellerFilterParameterName => array(),
            self::ConditionFilterParameterName => array()
        );

        $arr = explode('/', $queryString);

        $memoryKey = null;
        $memoryValue = null;

        foreach ($arr as $element) {
            if (in_array($element, self::$unvalidKeys) || empty($element)) continue;

            if (array_key_exists($element, $sort)) {
                $memoryKey = $element;
            } else {
                $element = self::clearValue($element);

                $memoryValue = (int)$element ? (int)$element : $element;
            }

            if ($memoryKey && $memoryValue) {
                $sort[$memoryKey][] = $memoryValue;

                $memoryKey = null;
                $memoryValue = null;
            }
        }

        return $sort;
    }

    private static function mergeFilterItemsQuery($items)
    {
        $query = '';
        $count = count($items);

        for ($i = 0; $i < $count; $i++) {
            if (!$items[$i]->hasQuery()) continue;

            $itemQuery = $items[$i]->getQuery();

            if (strlen($query) == 0) {
                $query .= $itemQuery;
            } else {
                $query .= ' AND ' . $itemQuery;
            }
        }

        return $query;
    }

    private static function mergeFilterItemsParams($items)
    {
        $parameters = array();

        foreach ($items as $item) {
            if (!$item->hasParameters()) continue;

            $parameters = array_merge($parameters, $item->getParameters());
        }

        return $parameters;
    }

    private static function clearValue($value){
        $delimiter = '?';

        if(strpos($value, $delimiter) !== false){
            $arr = explode($delimiter, $value);

            return $arr[0]; // ---------------- val1 from val1?par=val2
        }
        else return $value;
    }
}


















