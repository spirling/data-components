<?php

namespace Spirling\DataComponents\Interfaces;

/**
 * Interface FactoryInterface
 *
 * @package Spirling\DataComponents\Interfaces
 */
interface FactoryInterface
{

    /**
     * Create data object based on array of data
     *
     * @param array $data
     *
     * @return DataProviderInterface
     */
    public function create(array $data) : DataProviderInterface;

}