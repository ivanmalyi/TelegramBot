<?php

declare(strict_types=1);

namespace System\Repository\Sections;


use System\Entity\Repository\Section;

interface SectionsRepositoryInterface
{
    /**
     * @return Section[]
     */
    public function findAllSections(): array;

    public function clearSections();

    /**
     * @param Section[] $sections
     * @return int
     */
    public function saveSections(array $sections): int;
}