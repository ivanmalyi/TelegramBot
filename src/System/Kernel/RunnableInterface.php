<?php

declare(strict_types=1);

namespace System\Kernel;

/**
 * Interface RunnableInterface
 *
 * Interface for objects, containing method run
 *
 * @package System\Kernel
 */
interface RunnableInterface
{
    /**
     * Runs some code
     *
     * @return void
     */
    public function run();
}
