<?php

namespace System\Util\Validation;

/**
 * Interface ValidationResultInterface
 * @package System\Util\Validation
 */
interface ValidationResultInterface extends \Countable, \Traversable, \IteratorAggregate
{
    /**
     * Returns true if validation process done with success
     *
     * @return boolean
     */
    public function success();

    /**
     * Returns array of exceptions
     *
     * @return \Exception[]
     */
    public function getErrors();
}
