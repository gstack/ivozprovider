<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180409084119 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tp_rates DROP INDEX IDX_DE7E762B2B3C4634, ADD UNIQUE INDEX UNIQ_DE7E762B2B3C4634 (tpDestinationRateId)');
        $this->addSql('ALTER TABLE tp_destination_rates DROP INDEX IDX_4823F9F84EB67480, ADD UNIQUE INDEX UNIQ_4823F9F84EB67480 (destinationRateId)');
        $this->addSql('ALTER TABLE tp_destinations DROP INDEX IDX_C98068852B3C4634, ADD UNIQUE INDEX UNIQ_C98068852B3C4634 (tpDestinationRateId)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tp_destination_rates DROP INDEX UNIQ_4823F9F84EB67480, ADD INDEX IDX_4823F9F84EB67480 (destinationRateId)');
        $this->addSql('ALTER TABLE tp_destinations DROP INDEX UNIQ_C98068852B3C4634, ADD INDEX IDX_C98068852B3C4634 (tpDestinationRateId)');
        $this->addSql('ALTER TABLE tp_rates DROP INDEX UNIQ_DE7E762B2B3C4634, ADD INDEX IDX_DE7E762B2B3C4634 (tpDestinationRateId)');
    }
}
