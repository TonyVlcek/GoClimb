<?php

namespace OnlineClimbing\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151126004524 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE route ADD builder_id INT UNSIGNED NOT NULL AFTER line_id');
		$this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079959F66E4 FOREIGN KEY (builder_id) REFERENCES user (id)');
		$this->addSql('CREATE INDEX IDX_2C42079959F66E4 ON route (builder_id)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079959F66E4');
		$this->addSql('DROP INDEX IDX_2C42079959F66E4 ON route');
		$this->addSql('ALTER TABLE route DROP builder_id');
	}
}
