<?php

use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;

final class CreatePerfis implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::createIfNotExists('perfis');
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::drop('perfis');
    }
}
