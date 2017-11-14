<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171111105020 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ismaserrano_portfoliobundle_project_pages (id BIGINT AUTO_INCREMENT NOT NULL, project_id BIGINT DEFAULT NULL, title VARCHAR(255) NOT NULL, page_title VARCHAR(255) DEFAULT NULL, INDEX IDX_CD2BC26F166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_project_pages ADD CONSTRAINT FK_CD2BC26F166D1F9C FOREIGN KEY (project_id) REFERENCES ismaserrano_portfoliobundle_projects (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ismaserrano_portfoliobundle_project_pages');
    }
}
