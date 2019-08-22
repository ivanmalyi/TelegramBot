<?php

declare(strict_types=1);

namespace System\Component;

/**
 * Interface DaemonComponentProviderInterface
 * @package System\Component
 */
interface DaemonComponentInterface
{
    /**
     * @param string $name
     * @return int
     */
    public function getStatus(string $name): int;
}
