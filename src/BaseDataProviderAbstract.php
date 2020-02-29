<?php

namespace Spirling\DataComponents;

use Spirling\DataComponents\Exceptions\PropertyNotFoundException;
use Spirling\DataComponents\Traits\EditableTrait;

/**
 * Class BaseDataMapper
 *
 * @package Spirling\DataComponents
 */
abstract class BaseDataProviderAbstract extends DataProviderAbstract
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
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->isEditable() and $this->id = $id;
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

}