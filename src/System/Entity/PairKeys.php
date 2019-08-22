<?php

declare(strict_types=1);

namespace System\Entity;

class PairKeys
{
    /**
     * @var string
     */
    private $private;

    /**
     * @var string
     */
    private $public;

    /**
     * @param string $private
     * @param string $public
     */
    public function __construct(string $private, string $public)
    {
        $this->private = $private;
        $this->public = $public;
    }

    /**
     * @return string
     */
    public function getPrivate() : string
    {
        return $this->private;
    }

    /**
     * @return string
     */
    public function getPublic() : string
    {
        return $this->public;
    }
}
