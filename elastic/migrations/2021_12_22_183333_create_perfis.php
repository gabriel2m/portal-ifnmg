<?php

use App\Models\Perfil;
use ElasticMigrations\Facades\Index;
use ElasticMigrations\MigrationInterface;

final class CreatePerfis implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::createIfNotExists(Perfil::TABLE);
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::drop(Perfil::TABLE);
    }
}
