<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230527142357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE club ADD actif BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE club ADD date_creation TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE club ADD date_modification TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE joueur ADD actif BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE joueur ADD date_creation TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE joueur ADD date_modification TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE rencontre ADD actif BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE rencontre ADD date_creation TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE rencontre ADD date_modification TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE rencontre DROP actif');
        $this->addSql('ALTER TABLE rencontre DROP date_creation');
        $this->addSql('ALTER TABLE rencontre DROP date_modification');
        $this->addSql('ALTER TABLE joueur DROP actif');
        $this->addSql('ALTER TABLE joueur DROP date_creation');
        $this->addSql('ALTER TABLE joueur DROP date_modification');
        $this->addSql('ALTER TABLE club DROP actif');
        $this->addSql('ALTER TABLE club DROP date_creation');
        $this->addSql('ALTER TABLE club DROP date_modification');
    }
}
