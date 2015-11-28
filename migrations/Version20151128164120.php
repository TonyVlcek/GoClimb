<?php

namespace OnlineClimbing\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151128164120 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE file (id INT UNSIGNED AUTO_INCREMENT NOT NULL, wall_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_8C9F3610C33923F1 (wall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610C33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id)');
		$this->addSql('ALTER TABLE page CHANGE wall_id wall_id INT UNSIGNED DEFAULT NULL');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DROP TABLE file');
		$this->addSql('ALTER TABLE page CHANGE wall_id wall_id INT UNSIGNED NOT NULL');
	}
}