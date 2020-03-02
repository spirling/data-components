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
     * @var bool
     */
    private $init = true;

    /**
     * @var int
     */
    protected $id;

    /**
     * @return int|null
     */
    public function getId()
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
     * @param array $data
     *
     * @throws Exceptions\InvalidPropertyValueException
     * @throws Exceptions\PropertyAccessDeniedException
     * @throws PropertyNotFoundException
     */
    public function init(array $data)
    {
        if ($this->init) {

            if (array_key_exists('id', $data)) {
                $this->setId((int) $data['id']);
            }

            $data = $this->prepareData($data);

            foreach ($this->getDataFields() as $field => $label) {
                if (array_key_exists($field, $data)) {
                    $value = $this->prepare($field, $data[$field]);
                    $this->set($field, $value);
                } else {
                    throw new PropertyNotFoundException(sprintf('Property "%s" not found', $field));
                }
            }

            $this->init = false;
        }
    }

}