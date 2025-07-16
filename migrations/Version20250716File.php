<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250716File extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de la table file pour la plateforme de partage de fichiers';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE file (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            type VARCHAR(255) NOT NULL,
            path VARCHAR(255) NOT NULL,
            shared_link VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE file');
    }
}
