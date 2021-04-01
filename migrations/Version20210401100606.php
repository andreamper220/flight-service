<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210401100606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE flight_passenger ADD ticket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE flight_passenger ADD CONSTRAINT FK_25F7F56F700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_25F7F56F700047D2 ON flight_passenger (ticket_id)');
        $this->addSql('ALTER TABLE passenger ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT fk_97a0ada391f478c5');
        $this->addSql('DROP INDEX idx_97a0ada391f478c5');
        $this->addSql('ALTER TABLE ticket DROP flight_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE passenger DROP email');
        $this->addSql('ALTER TABLE flight_passenger DROP CONSTRAINT FK_25F7F56F700047D2');
        $this->addSql('DROP INDEX IDX_25F7F56F700047D2');
        $this->addSql('ALTER TABLE flight_passenger DROP ticket_id');
        $this->addSql('ALTER TABLE ticket ADD flight_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT fk_97a0ada391f478c5 FOREIGN KEY (flight_id) REFERENCES flight (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_97a0ada391f478c5 ON ticket (flight_id)');
    }
}
