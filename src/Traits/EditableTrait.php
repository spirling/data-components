<?php

namespace Spirling\DataComponents\Traits;

/**
 * Trait EditableTrait
 *
 * @package Spirling\DataComponents\Traits
 */
trait EditableTrait
{

    /**
     * @var bool
     */
    protected $isEditable = true;

    /**
     * Enable object for edit
     */
    protected function enableEdit()
    {
        $this->isEditable = true;
    }

    /**
     * Disable object for edit
     */
    protected function disableEdit()
    {
        $this->isEditable = false;
    }

    /**
     * Check if object is editable
     *
     * @return bool
     */
    public function isEditable()
    {
        return $this->isEditable;
    }

}