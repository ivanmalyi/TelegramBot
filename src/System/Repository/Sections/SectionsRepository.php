<?php

declare(strict_types=1);

namespace System\Repository\Sections;

use System\Entity\Repository\Section;
use System\Repository\AbstractPdoRepository;

/**
 * Class SectionsRepository
 * @package System\Repository\Sections
 */
class SectionsRepository extends AbstractPdoRepository implements SectionsRepositoryInterface
{
    /**
     * @return Section[]
     */
    public function findAllSections(): array
    {
        $sql = 'select id, name_ua, name_ru, name_en
                from sections';

        $rows = $this->execAssoc($sql, []);

        $sections = [];
        foreach ($rows as $row) {
            $sections[] = $this->inflate($row);
        }
        return  $sections;
    }

    /**
     * @param array $row
     * @return Section
     */
    private function inflate(array $row): Section
    {
        return new Section(
            $row['name_ua'],
            $row['name_ru'],
            $row['name_en'],
            (int)$row['id']
        );
    }

    public function clearSections()
    {
        $sql = 'truncate table sections';
        $this->update($sql, []);
    }

    /**
     * @param Section[] $sections
     * @return int
     * @throws \System\Exception\DiException
     */
    public function saveSections(array $sections): int
    {
        $sql =/**@lang tetx*/
            'insert into sections (id, name_ua, name_ru, name_en) values ';
        $placeholders = [];
        foreach ($sections as $key=>$section) {
            $sql .="(:id{$key}, :nameUa{$key}, :nameRu{$key}, :nameEn{$key}),";
            $placeholders += [
                "id{$key}"=>$section->getId(),
                "nameUa{$key}"=>$section->getNameUa(),
                "nameRu{$key}"=>$section->getNameRu(),
                "nameEn{$key}"=>$section->getNameEn(),
            ];
        }

        return $this->insert(rtrim($sql, ','), $placeholders);
    }
}