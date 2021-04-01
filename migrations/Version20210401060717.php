<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210401060717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE flight_passenger_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE place_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ticket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE company (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE document (id INT NOT NULL, owner_id INT DEFAULT NULL, type_id INT NOT NULL, series VARCHAR(255) DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D8698A767E3C61F9 ON document (owner_id)');
        $this->addSql('CREATE TABLE flight_passenger (id INT NOT NULL, flight_id INT DEFAULT NULL, passenger_id INT DEFAULT NULL, status_id INT DEFAULT NULL, seat_number INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_25F7F56F91F478C5 ON flight_passenger (flight_id)');
        $this->addSql('CREATE INDEX IDX_25F7F56F4502E565 ON flight_passenger (passenger_id)');
        $this->addSql('CREATE INDEX IDX_25F7F56F6BF700BD ON flight_passenger (status_id)');
        $this->addSql('CREATE TABLE place (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE status (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ticket (id INT NOT NULL, flight_id INT DEFAULT NULL, is_archive BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_97A0ADA391F478C5 ON ticket (flight_id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A767E3C61F9 FOREIGN KEY (owner_id) REFERENCES passenger (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_passenger ADD CONSTRAINT FK_25F7F56F91F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_passenger ADD CONSTRAINT FK_25F7F56F4502E565 FOREIGN KEY (passenger_id) REFERENCES passenger (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_passenger ADD CONSTRAINT FK_25F7F56F6BF700BD FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA391F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ALTER departure_id DROP NOT NULL');
        $this->addSql('ALTER TABLE flight ALTER destination_id DROP NOT NULL');
        $this->addSql('ALTER TABLE flight ALTER company_id DROP NOT NULL');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E7704ED06 FOREIGN KEY (departure_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E816C6140 FOREIGN KEY (destination_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C257E60E7704ED06 ON flight (departure_id)');
        $this->addSql('CREATE INDEX IDX_C257E60E816C6140 ON flight (destination_id)');
        $this->addSql('CREATE INDEX IDX_C257E60E979B1AD6 ON flight (company_id)');
        $this->addSql('ALTER TABLE passenger DROP document_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E979B1AD6');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E7704ED06');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E816C6140');
        $this->addSql('ALTER TABLE flight_passenger DROP CONSTRAINT FK_25F7F56F6BF700BD');
        $this->addSql('DROP SEQUENCE company_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE document_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE flight_passenger_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE place_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ticket_id_seq CASCADE');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE flight_passenger');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP INDEX IDX_C257E60E7704ED06');
        $this->addSql('DROP INDEX IDX_C257E60E816C6140');
        $this->addSql('DROP INDEX IDX_C257E60E979B1AD6');
        $this->addSql('ALTER TABLE flight ALTER departure_id SET NOT NULL');
        $this->addSql('ALTER TABLE flight ALTER destination_id SET NOT NULL');
        $this->addSql('ALTER TABLE flight ALTER company_id SET NOT NULL');
        $this->addSql('ALTER TABLE passenger ADD document_id INT NOT NULL');
    }
}
