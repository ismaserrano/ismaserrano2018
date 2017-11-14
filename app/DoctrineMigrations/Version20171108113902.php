<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171108113902 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ismaserrano_portfoliobundle_projectss (id BIGINT AUTO_INCREMENT NOT NULL, images_id BIGINT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, body LONGTEXT DEFAULT NULL, images_alt_text LONGTEXT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, created DATETIME DEFAULT NULL, status TINYINT(1) DEFAULT NULL, INDEX IDX_75785B6FD44F05E5 (images_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_projectss ADD CONSTRAINT FK_75785B6FD44F05E5 FOREIGN KEY (images_id) REFERENCES kuma_media (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ismaserrano_portfoliobundle_projectss');
    }
}
