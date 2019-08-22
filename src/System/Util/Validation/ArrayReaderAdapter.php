<?php

namespace System\Util\Validation;

use System\Exception\Protocol\MissingArgumentException;
use System\Exception\Protocol\ValidateArgumentException;

/**
 * Class ArrayReaderAdapter
 * @package System\Util
 */
class ArrayReaderAdapter
{
    /**
     * @var array
     */
    private $data;

    /**
     * ArrayReaderAdapter constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @param bool $isMandatory
     * @param mixed $default
     * @return mixed
     * @throws MissingArgumentException
     */
    public function read($key, $isMandatory, $default = null)
    {
        if (!array_key_exists($key, $this->data)) {
            if ($isMandatory) {
                throw new MissingArgumentException($key);
            } else {
                return $default;
            }
        }

        return $this->data[$key];
    }

    /**
     * @param ValidatorInterface $validator
     * @param $key
     * @param null $default
     * @return mixed
     * @throws MissingArgumentException
     * @throws ValidateArgumentException
     */
    public function readWith(ValidatorInterface $validator, $key, $default = null)
    {
        if (isset($default)) {
            $value = $this->read($key, false, $default);
        } else {
            $value = $this->read($key, true);
        }

        if (!$validator->validate($value)->success()) {
            throw new ValidateArgumentException($key);
        }
        return $value;
    }
}
