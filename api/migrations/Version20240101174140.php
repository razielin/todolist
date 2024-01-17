<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101174140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create users tasks';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('task');
        $table->addColumn('task_id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $table->setPrimaryKey(array('task_id'));
        $table->addColumn('task_text', 'string');
        $table->addColumn('task_completed', 'boolean');
        $table->addColumn('task_view_count', 'integer');
        $table->addColumn('task_date', 'datetime');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('user');
    }
}
