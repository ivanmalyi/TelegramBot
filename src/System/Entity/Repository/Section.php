<?php

declare(strict_types = 1);

namespace System\Entity\Repository;


/**
 * Class Section
 * @package System\Entity\Repository
 */
class Section
{
    /**
     * @var string
     */
    private $nameUa;

    /**
     * @var string
     */
    private $nameRu;

    /**
     * @var string
     */
    private $nameEn;

    /**
     * @var int
     */
    private $id;

    /**
     * Section constructor.
     * @param string $nameUa
     * @param string $nameRu
     * @param string $nameEn
     * @param int $id
     */
    public function __construct(string $nameUa, string $nameRu, string $nameEn, int $id = 0)
    {
        $this->nameUa = $nameUa;
        $this->nameRu = $nameRu;
        $this->nameEn = $nameEn;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNameUa(): string
    {
        return $this->nameUa;
    }

    /**
     * @return string
     */
    public function getNameRu(): string
    {
        return $this->nameRu;
    }

    /**
     * @return string
     */
    public function getNameEn(): string
    {
        return $this->nameEn;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}