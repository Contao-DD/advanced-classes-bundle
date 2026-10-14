<?php

declare(strict_types=1);

/*
 * advanced-classes-bundle for Contao Open Source CMS
 *
 * Copyright (c) 2026 Contao Stammtisch Dresden
 *
 * @package advanced-classes
 * @author Mathias Arzberger <develop@pdir.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace ContaoDD\AdvancedClassesBundle\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\Connection;

/**
 * Resets root pages and forms that still use a set which has been removed from
 * the bundle.
 */
class RemovedSetsMigration extends AbstractMigration
{
    private const REMOVED_SETS = [
        'bundles/contaoddadvancedclasses/sets/bootstrap2.json',
        'bundles/contaoddadvancedclasses/sets/bootstrap3.json',
        'bundles/contaoddadvancedclasses/sets/bootstrap4-alpha.json',
    ];

    private const TABLES = ['tl_page', 'tl_form'];

    public function __construct(private readonly Connection $connection)
    {
    }

    public function shouldRun(): bool
    {
        foreach ($this->getTables() as $table) {
            $count = $this->connection->fetchOne(
                "SELECT COUNT(*) FROM $table WHERE ac_set IN (?)",
                [self::REMOVED_SETS],
                [ArrayParameterType::STRING],
            );

            if ($count > 0) {
                return true;
            }
        }

        return false;
    }

    public function run(): MigrationResult
    {
        foreach ($this->getTables() as $table) {
            $this->connection->executeStatement(
                "UPDATE $table SET ac_set = '' WHERE ac_set IN (?)",
                [self::REMOVED_SETS],
                [ArrayParameterType::STRING],
            );
        }

        return $this->createResult(true);
    }

    private function getTables(): array
    {
        $schemaManager = $this->connection->createSchemaManager();

        return array_filter(
            self::TABLES,
            static fn (string $table): bool => $schemaManager->tablesExist([$table])
                && isset($schemaManager->listTableColumns($table)['ac_set']),
        );
    }
}
