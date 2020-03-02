<?php

namespace Spirling\DataComponents;

use DateTime;
use Exception;
use Spirling\DataComponents\Interfaces\DataMapperInterface;

/**
 * Class DataMapperAbstract
 *
 * @package Spirling\DataComponents
 */
abstract class DataMapperAbstract implements DataMapperInterface
{

    const DATE_FORMAT = 'Y-m-d H:i:s';

    const PARAM_STRING = 'string';
    const PARAM_INT = 'int';
    const PARAM_DATE = 'date';
    const PARAM_FLOAT = 'float';

    /**
     * Array of table data fields in format
     * * [<property_name> => <field_name>]
     *
     * @return array
     */
    abstract protected function getTableDataFields() : array;

    /**
     * Array of table data fields in format
     * * [<field_name> => <data_type>]
     *
     * @return array
     */
    abstract protected function getTableDataTypes() : array;

    /**
     * Prepare value for saving
     *
     * @param string $name
     * @param mixed $value
     *
     * @return mixed
     */
    protected function prepare(string $name, $value)
    {
        $prepareMethod = 'prepare' . ucfirst($name);
        if (method_exists($this, $prepareMethod)) {
            $value = $this->$prepareMethod($value);
        }
        return $value;
    }

    /**
     * Prepare data
     *
     * @param array $data
     *
     * @return array
     */
    protected function prepareData(array $data) : array
    {
        $fields = $this->getTableDataFields();
        $types = $this->getTableDataTypes();

        $result = [];
        foreach ($data as $property => $value) {
            if (array_key_exists($property, $fields)) {
                $field = $fields[$property];
                $this->prepareDataItem($field, $value);
                $this->prepare($property, $value);

                $result[$field] = $value;
            }
        }
        return $result;
    }

    protected function prepareDataItem($field, $value)
    {
        $type = $this->getTableDataTypes()[$field];
        switch ($type) {
            case self::PARAM_INT:
                $value = (int) $value;
                break;
            case self::PARAM_FLOAT:
                $value = (float) $value;
                break;
            case self::PARAM_DATE:
                if ($value instanceof DateTime) {
                    $value = $value->format(static::DATE_FORMAT);
                } elseif (is_int($value)) {
                    $value = date(static::DATE_FORMAT);
                } else {
                    try {
                        $date = new DateTime($value);
                        $value = $date->format(static::DATE_FORMAT);
                    } catch (Exception $exception) {
                        $value = date(static::DATE_FORMAT);
                    }
                }
                break;
            case self::PARAM_STRING:
            default:
                $value = (string) $value;
                break;
        }
        return $value;
    }

}