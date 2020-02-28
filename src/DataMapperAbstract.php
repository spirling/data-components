<?php

namespace Spirling\DataComponents;

use Spirling\DataComponents\Interfaces\DataMapperInterface;

/**
 * Class DataMapperAbstract
 *
 * @package Spirling\DataComponents
 */
abstract class DataMapperAbstract implements DataMapperInterface
{

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

    abstract protected function prepare($name, $value);

    abstract protected function insert(array $data);

    abstract protected function update(array $data);

    abstract protected function delete(array $data);

    protected function prepareData(array $data)
    {

    }

}