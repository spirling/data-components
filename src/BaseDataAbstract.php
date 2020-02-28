<?php

namespace Spirling\DataComponents;

use Spirling\DataComponents\Exceptions\PropertyNotFoundException;
use Spirling\DataComponents\Traits\EditableTrait;

/**
 * Class BaseDataMapper
 *
 * @package Spirling\DataComponents
 */
abstract class BaseDataAbstract extends DataAbstract
{

    use EditableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Initialize object with data
     *
     * @param int $id
     * @param array $data
     *
     * @throws Exceptions\InvalidPropertyValueException
     * @throws Exceptions\PropertyAccessDeniedException
     * @throws PropertyNotFoundException
     */
    public function init(int $id, array $data)
    {
        static $init = true;
        if ($init) {

            $this->id = (int) $id;

            foreach ($this->getDataFields() as $field => $label) {
                if (array_key_exists($field, $data)) {
                    $value = $this->prepare($field, $data[$field]);
                    $this->set($field, $value);
                } else {
                    throw new PropertyNotFoundException(sprintf('Property "%s" not found', $name));
                }
            }

            $init = false;
        }
    }

    /**
     * @inheritDoc
     * @rewrite
     */
    public function getDataFields() : array
    {
        // TODO: Implement getDataFields() method.
        return [];
    }

}