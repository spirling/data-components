<?php

namespace Spirling\DataComponents;

use DateTime;
use Spirling\DataComponents\Interfaces\DataMapperInterface;

/**
 * Class DataMapperAbstract
 *
 * @package Spirling\DataComponents
 */
abstract class DataMapperAbstract implements DataMapperInterface
{

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
    abstract protected function prepare(string $name, $value);

    abstract protected function prepareData(array $data) : array;

}