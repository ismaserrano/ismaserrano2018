<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171109085155 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_project_page_part_project DROP INDEX UNIQ_DB1DAF1B166D1F9C, ADD INDEX IDX_DB1DAF1B166D1F9C (project_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ismaserrano_portfoliobundle_project_page_part_project DROP INDEX IDX_DB1DAF1B166D1F9C, ADD UNIQUE INDEX UNIQ_DB1DAF1B166D1F9C (project_id)');
    }
}
