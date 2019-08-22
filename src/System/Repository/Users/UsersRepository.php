<?php

declare(strict_types=1);

namespace System\Repository\Users;

use System\Entity\Repository\User;
use System\Repository\AbstractPdoRepository;

/**
 * Class UsersRepository
 * @package System\Repository\Users
 */
class UsersRepository extends AbstractPdoRepository implements UsersRepositoryInterface
{
    /**
     * @param User $user
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function create(User $user): int
    {
        $sql = 'insert into users (first_name, last_name, phone_number, created_at, updated_at) 
                value (:firstName, :lastName, :phoneNumber, :createdAt, :updatedAt)';

        return $this->insert($sql, [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'phoneNumber' => $user->getPhoneNumber(),
            'createdAt' => $user->getCreatedAt(),
            'updatedAt' => $user->getUpdatedAt()
        ]);
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param int $id
     *
     * @return int
     *
     * @throws \System\Exception\DiException
     */
    public function updateUserInfo(string $firstName, string $lastName, int $id): int
    {
        $sql = 'update users
          set first_name=:firstName, last_name=:lastName, updated_at=now()
          where id=:id';

        return $this->insert($sql, [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'id' => $id
        ]);
    }
}