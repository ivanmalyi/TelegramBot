<?php

namespace System\Util\Validation;

/**
 * Class ValidationResult
 *
 * @package System\Util\Validation
 */
class ValidationResult implements ValidationResultInterface
{
    /**
     * List of exceptions
     *
     * @var \Exception[]
     */
    private $exceptions = [];

    /**
     * Constructor
     *
     * @param \Exception $exception
     */
    public function __construct(\Exception $exception = null)
    {
        if ($exception !== null) {
            $this->addException($exception);
        }
    }

    /**
     * Adds new exception to the pool
     *
     * @param \Exception $exception
     */
    public function addException(\Exception $exception)
    {
        $this->exceptions[] = $exception;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->exceptions);
    }

    /**
     * Returns amount of errors occurred
     *
     * @return int
     */
    public function count()
    {
        return count($this->exceptions);
    }

    /**
     * Returns true if validation process done with success
     *
     * @return boolean
     */
    public function success()
    {
        return count($this->exceptions) === 0;
    }

    /**
     * Returns array of exceptions
     *
     * @return \Exception[]
     */
    public function getErrors()
    {
        return $this->exceptions;
    }
}
