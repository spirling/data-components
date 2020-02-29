<?php

namespace Spirling\DataComponents\Interfaces;

use Spirling\DataComponents\Exceptions\MappingException;

/**
 * Interface DataMapperInterface
 *
 * @package Spirling\DataComponents\Interfaces
 */
interface DataMapperInterface
{

    /**
     * Save data object into data storage
     *
     * @param DataProviderInterface $dataProvider
     *
     * @throws MappingException
     */
    public function save(DataProviderInterface $dataProvider) : void;

    /**
     * Remove data from data storage
     *
     * @param DataProviderInterface $dataProvider
     *
     * @throws MappingException
     */
    public function remove(DataProviderInterface $dataProvider) : void;

    /**
     * Get row of data filtered by conditions (it will return only 1 row)
     *
     * @param array $conditions conditions for filtering rows
     * @param array $orderings ordering
     *
     * @return DataProviderInterface
     * @throws MappingException
     */
    public function get(array $conditions, array $orderings = []) : DataProviderInterface;

    /**
     * Get row of data filtered on $fieldName by $value
     *
     * @param string $fieldName
     * @param mixed $value
     * @param array $orderings
     *
     * @return DataProviderInterface
     * @throws MappingException
     */
    public function getBy(string $fieldName, $value, array $orderings = []) : DataProviderInterface;

    /**
     * Get limited rows filtered by conditions
     *
     * @param array $conditions
     * @param array $orderings
     * @param array $limits
     *
     * @return DataProviderInterface[]
     */
    public function getAll(array $conditions, array $orderings = [], array $limits = []) : array;

}