<?php

namespace Spirling\DataComponents;

use Spirling\DataComponents\Exceptions\PropertyNotFoundException;
use Spirling\DataComponents\Interfaces\DataProviderInterface;

abstract class DataProviderAbstract implements DataProviderInterface
{

    /**
     * @inheritDoc
     */
    public function get(string $name)
    {
        $result = null;
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            $result = $this->$getter();
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function set(string $name, $value)
    {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } else {
            throw new PropertyNotFoundException(sprintf('Property "%s" not found', $name));
        }
    }

    /**
     * @inheritDoc
     */
    public function isset(string $name) : bool
    {
        $value = $this->get($name);
        return isset($value);
    }

    /**
     * @inheritDoc
     */
    public function unset(string $name)
    {
        if (property_exists($this, $name)) {
            unset($this->$name);
        } else {
            throw new PropertyNotFoundException(sprintf('Property "%s" not found', $name));
        }
    }

    /**
     * @inheritDoc
     */
    public function prepare(string $name, $value)
    {
        $prepareMethod = 'prepare' . ucfirst($name);
        if (method_exists($this, $prepareMethod)) {
            $value = $this->$prepareMethod($value);
        }
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function validate(string $name, $value)
    {
        $validator = 'validate' . ucfirst($name);
        if (method_exists($this, $validator)) {
            $this->$validator($value);
        }
    }

    /**
     * @inheritDoc
     */
    public function getData() : array
    {
        $data = [];
        foreach ($this->getDataFields() as $field => $label) {
            $data[$field] = $this->get($field);
        }
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function setData(array $data)
    {
        foreach ($this->getDataFields() as $field => $value) {
            $value = $this->prepare($field, $value);
            $data[$field] = $this->set($field, $value);
        }
    }

    /**
     * @inheritDoc
     */
    public function prepareData(array $data) : array
    {
        $result = [];
        foreach ($this->getDataFields() as $field => $value) {
            $result[$field] = $this->prepare($field, $value);
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function validateData(array $data)
    {
        foreach ($data as $field => $value) {
            if (array_key_exists($field, $this->getDataFields())) {
                $this->validate($field, $value);
            } else {
                throw new PropertyNotFoundException(sprintf('Property "%s" not found', $field));
            }
        }
    }


}