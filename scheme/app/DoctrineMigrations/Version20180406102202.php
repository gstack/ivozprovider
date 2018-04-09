<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180406102202 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE kam_trunks_cdrs DROP FOREIGN KEY FK_92E58EB6BF3434FC');
        $this->addSql('ALTER TABLE tp_destination_rates DROP FOREIGN KEY FK_4823F9F8BF3434FC');
        $this->addSql('ALTER TABLE tp_destinations DROP FOREIGN KEY FK_C9806885BF3434FC');
        $this->addSql('ALTER TABLE tp_destination_rates DROP FOREIGN KEY FK_4823F9F8925F3C99');
        $this->addSql('ALTER TABLE tp_rates DROP FOREIGN KEY FK_DE7E762B925F3C99');
        $this->addSql('DROP TABLE Destinations');
        $this->addSql('DROP TABLE Rates');
        $this->addSql('ALTER TABLE kam_trunks_cdrs ADD CONSTRAINT FK_92E58EB6BF3434FC FOREIGN KEY (destinationId) REFERENCES tp_destinations (id) ON DELETE SET NULL');
        $this->addSql('DROP INDEX IDX_DE7E762B925F3C99 ON tp_rates');
        $this->addSql('DROP INDEX unique_tprate ON tp_rates');
        $this->addSql('ALTER TABLE tp_rates CHANGE rateid tpDestinationRateId INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE tp_rates ADD CONSTRAINT FK_DE7E762B2B3C4634 FOREIGN KEY (tpDestinationRateId) REFERENCES tp_destination_rates (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_DE7E762B2B3C4634 ON tp_rates (tpDestinationRateId)');
        $this->addSql('CREATE UNIQUE INDEX unique_tprate ON tp_rates (tpid, tag, group_interval_start, tpDestinationRateId)');
        $this->addSql('ALTER TABLE DestinationRates 
          ADD status VARCHAR(20) DEFAULT \'waiting\' COMMENT \'[enum:waiting|inProgress|imported|error]\', 
          ADD fileFileSize INT UNSIGNED DEFAULT NULL COMMENT \'[FSO]\', 
          ADD fileMimeType VARCHAR(80) DEFAULT NULL, 
          ADD fileBaseName VARCHAR(255) DEFAULT NULL'
        );
        $this->addSql('DROP INDEX IDX_4823F9F8BF3434FC ON tp_destination_rates');
        $this->addSql('DROP INDEX IDX_4823F9F8925F3C99 ON tp_destination_rates');
        $this->addSql('ALTER TABLE tp_destination_rates 
          ADD prefix VARCHAR(24) NOT NULL, 
          ADD prefix_name VARCHAR(60) NOT NULL, 
          ADD rate NUMERIC(10, 4) NOT NULL, 
          ADD connect_fee NUMERIC(10, 4) NOT NULL, 
          ADD rate_increment VARCHAR(16) NOT NULL, 
          ADD group_interval_start VARCHAR(16) DEFAULT \'0s\' NOT NULL, 
          DROP destinationId, 
          DROP rateId'
        );
        $this->addSql('DROP INDEX IDX_C9806885BF3434FC ON tp_destinations');
        $this->addSql('DROP INDEX tpid_dest_prefix ON tp_destinations');
        $this->addSql('ALTER TABLE tp_destinations 
          ADD name VARCHAR(64) DEFAULT NULL, 
          ADD description VARCHAR(255) DEFAULT NULL, 
          CHANGE destinationid tpDestinationRateId INT UNSIGNED NOT NULL
        ');
        $this->addSql('ALTER TABLE tp_destinations ADD CONSTRAINT FK_C98068852B3C4634 FOREIGN KEY (tpDestinationRateId) REFERENCES tp_destination_rates (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_C98068852B3C4634 ON tp_destinations (tpDestinationRateId)');
        $this->addSql('CREATE UNIQUE INDEX tpid_dest_prefix ON tp_destinations (tpid, tag, prefix, tpDestinationRateId)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Destinations (id INT UNSIGNED AUTO_INCREMENT NOT NULL, tag VARCHAR(64) DEFAULT NULL COLLATE utf8_general_ci, name_en VARCHAR(55) NOT NULL COLLATE utf8_general_ci, name_es VARCHAR(55) NOT NULL COLLATE utf8_general_ci, description_en VARCHAR(255) NOT NULL COLLATE utf8_general_ci, description_es VARCHAR(255) NOT NULL COLLATE utf8_general_ci, brandId INT UNSIGNED NOT NULL, UNIQUE INDEX destination_brandTag (tag, brandId), INDEX destination_brandId (brandId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Rates (id INT UNSIGNED AUTO_INCREMENT NOT NULL, tag VARCHAR(64) DEFAULT NULL COLLATE utf8_general_ci, name VARCHAR(255) NOT NULL COLLATE utf8_general_ci, brandId INT UNSIGNED NOT NULL, UNIQUE INDEX rate_brandTag (brandId, tag), INDEX rate_brandId (brandId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Destinations ADD CONSTRAINT FK_3502983B9CBEC244 FOREIGN KEY (brandId) REFERENCES Brands (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Rates ADD CONSTRAINT FK_851584389CBEC244 FOREIGN KEY (brandId) REFERENCES Brands (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE DestinationRates DROP status, DROP fileFileSize, DROP fileMimeType, DROP fileBaseName');
        $this->addSql('ALTER TABLE kam_trunks_cdrs DROP FOREIGN KEY FK_92E58EB6BF3434FC');
        $this->addSql('ALTER TABLE kam_trunks_cdrs ADD CONSTRAINT FK_92E58EB6BF3434FC FOREIGN KEY (destinationId) REFERENCES Destinations (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tp_destination_rates ADD destinationId INT UNSIGNED NOT NULL, ADD rateId INT UNSIGNED NOT NULL, DROP prefix, DROP prefix_name, DROP rate, DROP connect_fee, DROP rate_increment, DROP group_interval_start');
        $this->addSql('ALTER TABLE tp_destination_rates ADD CONSTRAINT FK_4823F9F8925F3C99 FOREIGN KEY (rateId) REFERENCES Rates (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tp_destination_rates ADD CONSTRAINT FK_4823F9F8BF3434FC FOREIGN KEY (destinationId) REFERENCES Destinations (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_4823F9F8BF3434FC ON tp_destination_rates (destinationId)');
        $this->addSql('CREATE INDEX IDX_4823F9F8925F3C99 ON tp_destination_rates (rateId)');
        $this->addSql('ALTER TABLE tp_destinations DROP FOREIGN KEY FK_C98068852B3C4634');
        $this->addSql('DROP INDEX IDX_C98068852B3C4634 ON tp_destinations');
        $this->addSql('DROP INDEX tpid_dest_prefix ON tp_destinations');
        $this->addSql('ALTER TABLE tp_destinations DROP name, DROP description, CHANGE tpdestinationrateid destinationId INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE tp_destinations ADD CONSTRAINT FK_C9806885BF3434FC FOREIGN KEY (destinationId) REFERENCES Destinations (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_C9806885BF3434FC ON tp_destinations (destinationId)');
        $this->addSql('CREATE UNIQUE INDEX tpid_dest_prefix ON tp_destinations (tpid, tag, prefix, destinationId)');
        $this->addSql('ALTER TABLE tp_rates DROP FOREIGN KEY FK_DE7E762B2B3C4634');
        $this->addSql('DROP INDEX IDX_DE7E762B2B3C4634 ON tp_rates');
        $this->addSql('DROP INDEX unique_tprate ON tp_rates');
        $this->addSql('ALTER TABLE tp_rates CHANGE tpdestinationrateid rateId INT UNSIGNED NOT NULL');
        $this->addSql('ALTER TABLE tp_rates ADD CONSTRAINT FK_DE7E762B925F3C99 FOREIGN KEY (rateId) REFERENCES Rates (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_DE7E762B925F3C99 ON tp_rates (rateId)');
        $this->addSql('CREATE UNIQUE INDEX unique_tprate ON tp_rates (tpid, tag, group_interval_start, rateId)');
    }
}
