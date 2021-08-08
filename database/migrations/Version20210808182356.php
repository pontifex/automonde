<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20210808182356 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE products (
            id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
            model_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\',
            description LONGTEXT NOT NULL,
            mileage_distance INT NOT NULL,
            mileage_unit VARCHAR(255) NOT NULL,
            price_amount INT NOT NULL,
            price_currency VARCHAR(255) NOT NULL,
            INDEX IDX_B3BA5A5A7975B7E7 (model_id),
            PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci`
            ENGINE = InnoDB'
        );

        $this->addSql('ALTER TABLE products
            ADD CONSTRAINT FK_B3BA5A5A7975B7E7
            FOREIGN KEY (model_id)
            REFERENCES models (id)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A7975B7E7');
        $this->addSql('DROP TABLE products');
    }
}
