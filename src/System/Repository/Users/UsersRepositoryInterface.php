<?php

declare(strict_types=1);

namespace System\Repository\Users;

use System\Entity\Repository\User;

/**
 * Interface UsersRepositoryInterface
 * @package System\Repository\Users
 */
interface UsersRepositoryInterface
{
    /**
     * @param User $user
     * @return int
     */
    public function create(User $user): int;

    /**
     * @param string $firstName
     * @param string $lastName
     * @param int $id
     *
     * @return int
     */
    public function updateUserInfo(string $firstName, string $lastName, int $id): int;
}