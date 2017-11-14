<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171108215405 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ismaserrano_portfoliobundle_project_page_parts (id BIGINT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ismaserrano_portfoliobundle_project_page_part_project (project_page_part_id BIGINT NOT NULL, project_id BIGINT NOT NULL, INDEX IDX_DB1DAF1B9C24441A (project_page_part_id), UNIQUE INDEX UNIQ_DB1DAF1B166D1F9C (project_id), PRIMARY KEY(project_page_part_id, project_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_project_page_part_project ADD CONSTRAINT FK_DB1DAF1B9C24441A FOREIGN KEY (project_page_part_id) REFERENCES ismaserrano_portfoliobundle_project_page_parts (id)');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_project_page_part_project ADD CONSTRAINT FK_DB1DAF1B166D1F9C FOREIGN KEY (project_id) REFERENCES ismaserrano_portfoliobundle_projects (id)');
        $this->addSql('DROP TABLE kuma_nodes_search');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_projects DROP FOREIGN KEY FK_75785B6FD44F05E5');
        $this->addSql('DROP INDEX IDX_1D928397D44F05E5 ON ismaserrano_portfoliobundle_projects');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_projects DROP images_id, DROP images_alt_text');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_project_page_part_project DROP FOREIGN KEY FK_DB1DAF1B9C24441A');
        $this->addSql('CREATE TABLE kuma_nodes_search (id BIGINT AUTO_INCREMENT NOT NULL, node_id BIGINT DEFAULT NULL, boost DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_1560AF72460D9FD7 (node_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kuma_nodes_search ADD CONSTRAINT FK_1560AF72460D9FD7 FOREIGN KEY (node_id) REFERENCES kuma_nodes (id)');
        $this->addSql('DROP TABLE ismaserrano_portfoliobundle_project_page_parts');
        $this->addSql('DROP TABLE ismaserrano_portfoliobundle_project_page_part_project');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_projects ADD images_id BIGINT DEFAULT NULL, ADD images_alt_text LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_projects ADD CONSTRAINT FK_75785B6FD44F05E5 FOREIGN KEY (images_id) REFERENCES kuma_media (id)');
        $this->addSql('CREATE INDEX IDX_1D928397D44F05E5 ON ismaserrano_portfoliobundle_projects (images_id)');
    }
}
