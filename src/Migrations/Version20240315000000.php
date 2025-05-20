<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240315000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add name fields to users table';
    }

    public function up(Schema $schema): void
    {
        // First, add the new columns
        $this->addSql('ALTER TABLE users ADD first_name VARCHAR(255) NOT NULL AFTER email');
        $this->addSql('ALTER TABLE users ADD middle_name VARCHAR(255) DEFAULT NULL AFTER first_name');
        $this->addSql('ALTER TABLE users ADD last_name VARCHAR(255) NOT NULL AFTER middle_name');

        // Update existing records to split the name field
        $this->addSql('UPDATE users SET first_name = SUBSTRING_INDEX(name, " ", 1)');
        $this->addSql('UPDATE users SET last_name = SUBSTRING_INDEX(name, " ", -1)');

        // Drop the old name column
        $this->addSql('ALTER TABLE users DROP name');
    }

    public function down(Schema $schema): void
    {
        // Add back the name column
        $this->addSql('ALTER TABLE users ADD name VARCHAR(255) NOT NULL AFTER email');

        // Combine first_name and last_name back into name
        $this->addSql('UPDATE users SET name = CONCAT(first_name, " ", last_name)');

        // Drop the new columns
        $this->addSql('ALTER TABLE users DROP first_name');
        $this->addSql('ALTER TABLE users DROP middle_name');
        $this->addSql('ALTER TABLE users DROP last_name');
    }
}