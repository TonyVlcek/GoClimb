<?php

namespace OnlineClimbing\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151125193544 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE route (id INT UNSIGNED AUTO_INCREMENT NOT NULL, line_id INT UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2C420794D7B7542 (line_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C420794D7B7542 FOREIGN KEY (line_id) REFERENCES wall (id)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DROP TABLE route');
	}
}
