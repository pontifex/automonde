<?php

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema as Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20210808182353 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE models (
            id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
            brand_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\',
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            INDEX IDX_E4D6300944F5D008 (brand_id),
            PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci`
            ENGINE = InnoDB'
        );

        $this->addSql('ALTER TABLE models
            ADD CONSTRAINT FK_E4D6300944F5D008
            FOREIGN KEY (brand_id)
            REFERENCES brands (id)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE models DROP FOREIGN KEY FK_E4D6300944F5D008');
        $this->addSql('DROP TABLE models');
    }
}
