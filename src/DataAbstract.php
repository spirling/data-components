<?php

namespace Spirling\DataComponents;

use Spirling\DataComponents\Exceptions\PropertyNotFoundException;
use Spirling\DataComponents\Interfaces\DataInterface;

abstract class DataAbstract implements DataInterface
{

    /**
     * @inheritDoc
     */
    public function get(string $name)
    {
        $result = null;
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            $result = $this->$getter($name);
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function set(string $name, $value) : void
    {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) {
            $this->$setter($name, $value);
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
    public function unset(string $name) : void
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
            $value = $this->$prepareMethod($name, $value);
        }
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function validate(string $name, $value) : void
    {
        $validator = 'validate' . ucfirst($name);
        if (method_exists($this, $validator)) {
            $this->$validator($name, $value);
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
    public function setData(array $data) : void
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
    public function validateData(array $data) : void
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