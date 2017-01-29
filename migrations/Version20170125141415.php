<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170125141415 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE rating (id INT UNSIGNED AUTO_INCREMENT NOT NULL, author_id INT UNSIGNED NOT NULL, route_id INT UNSIGNED NOT NULL, note LONGTEXT NOT NULL, rating SMALLINT NOT NULL, created_date DATETIME NOT NULL, INDEX IDX_D8892622F675F31B (author_id), INDEX IDX_D889262234ECB4E6 (route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
		$this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D889262234ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
		$this->addSql('ALTER TABLE log ADD tries SMALLINT NOT NULL');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DROP TABLE rating');
		$this->addSql('ALTER TABLE log DROP tries');
	}
}
