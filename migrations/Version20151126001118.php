<?php

namespace OnlineClimbing\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151126001118 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE page CHANGE wall_id wall_id INT UNSIGNED DEFAULT NULL');
		$this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C420794D7B7542');
		$this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C420794D7B7542 FOREIGN KEY (line_id) REFERENCES line (id)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE page CHANGE wall_id wall_id INT UNSIGNED NOT NULL');
		$this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C420794D7B7542');
		$this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C420794D7B7542 FOREIGN KEY (line_id) REFERENCES wall (id)');
	}
}
