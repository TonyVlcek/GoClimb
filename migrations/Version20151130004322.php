<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151130004322 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE rest_token (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED NOT NULL, wall_id INT UNSIGNED NOT NULL, token VARCHAR(255) NOT NULL, remote_ip VARCHAR(255) NOT NULL, expiration DATETIME NOT NULL, INDEX IDX_59F77777A76ED395 (user_id), INDEX IDX_59F77777C33923F1 (wall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE rest_token ADD CONSTRAINT FK_59F77777A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
		$this->addSql('ALTER TABLE rest_token ADD CONSTRAINT FK_59F77777C33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DROP TABLE rest_token');
	}
}
