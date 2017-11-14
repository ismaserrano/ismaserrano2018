<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171108153705 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ismaserrano_portfoliobundle_image_gallery_item_page_parts (id BIGINT AUTO_INCREMENT NOT NULL, media_id BIGINT DEFAULT NULL, project_id BIGINT DEFAULT NULL, media_alt_text LONGTEXT DEFAULT NULL, INDEX IDX_D7ACB30EEA9FDD75 (media_id), INDEX IDX_D7ACB30E166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_image_gallery_item_page_parts ADD CONSTRAINT FK_D7ACB30EEA9FDD75 FOREIGN KEY (media_id) REFERENCES kuma_media (id)');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_image_gallery_item_page_parts ADD CONSTRAINT FK_D7ACB30E166D1F9C FOREIGN KEY (project_id) REFERENCES ismaserrano_portfoliobundle_projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_projects DROP FOREIGN KEY FK_75785B6FD44F05E5');
        $this->addSql('DROP INDEX idx_75785b6fd44f05e5 ON ismaserrano_portfoliobundle_projects');
        $this->addSql('CREATE INDEX IDX_1D928397D44F05E5 ON ismaserrano_portfoliobundle_projects (images_id)');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_projects ADD CONSTRAINT FK_75785B6FD44F05E5 FOREIGN KEY (images_id) REFERENCES kuma_media (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ismaserrano_portfoliobundle_image_gallery_item_page_parts');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_projects DROP FOREIGN KEY FK_1D928397D44F05E5');
        $this->addSql('DROP INDEX idx_1d928397d44f05e5 ON ismaserrano_portfoliobundle_projects');
        $this->addSql('CREATE INDEX IDX_75785B6FD44F05E5 ON ismaserrano_portfoliobundle_projects (images_id)');
        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_projects ADD CONSTRAINT FK_1D928397D44F05E5 FOREIGN KEY (images_id) REFERENCES kuma_media (id)');
    }
}
