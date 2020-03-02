<?php

namespace Spirling\DataComponents\Interfaces;

use Spirling\DataComponents\Exceptions\InvalidPropertyValueException;
use Spirling\DataComponents\Exceptions\PropertyAccessDeniedException;
use Spirling\DataComponents\Exceptions\PropertyNotFoundException;

/**
 * Interface DataInterface
 *
 * @package Spirling\DataComponents\Interfaces
 */
interface DataProviderInterface
{

    /**
     * Returns an array of data fields in format:
     * * [<property_name> => <label>]
     *
     * @return array
     */
    public function getDataFields() : array;

    /**
     * Get property value
     *
     * @param string $name property name
     *
     * @return mixed
     */
    public function get(string $name);

    /**
     * Set property value
     *
     * @param string $name property name
     * @param mixed $value property value to set
     *
     * @throws InvalidPropertyValueException
     * @throws PropertyAccessDeniedException
     * @throws PropertyNotFoundException
     */
    public function set(string $name, $value) ;

    /**
     * Check property isset
     *
     * @param string $name property name
     *
     * @return bool
     */
    public function isset(string $name) : bool;

    /**
     * Unset property
     *
     * @param string $name property name
     *
     * @throws PropertyAccessDeniedException
     * @throws PropertyNotFoundException
     */
    public function unset(string $name) ;

    /**
     * @param string $name property name
     * @param mixed $value property value to prepare
     *
     * @return mixed
     */
    public function prepare(string $name, $value);

    /**
     * Validate property
     *
     * @param string $name property name
     * @param mixed $value property value to validate
     *
     * @throws InvalidPropertyValueException
     */
    public function validate(string $name, $value) ;

    /**
     * Get an array of properties current values in format
     * * [<property_name> => <property_value>]
     *
     * @return array
     */
    public function getData() : array;

    /**
     * Set properties values from array in format
     * * [<property_name> => <property_value>]
     *
     * @param array $data
     *
     * @throws InvalidPropertyValueException
     * @throws PropertyAccessDeniedException
     * @throws PropertyNotFoundException
     */
    public function setData(array $data) ;

    /**
     * Prepare array of data to correspond with array format
     * * [<property_name> => <property_value>]
     * and to contain only available properties
     *
     * @param array $data
     *
     * @return array
     */
    public function prepareData(array $data) : array;

    /**
     * Validate array of data in format
     * * [<property_name> => <property_value>]
     *
     * @param array $data
     *
     * @throws InvalidPropertyValueException
     * @throws PropertyNotFoundException
     */
    public function validateData(array $data) ;

}