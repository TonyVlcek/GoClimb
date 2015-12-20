<?php

namespace OnlineClimbing\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151222204258 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE user ADD email VARCHAR(255) NOT NULL, ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, ADD age INT DEFAULT NULL, ADD height INT DEFAULT NULL, ADD weight INT DEFAULT NULL, ADD phone VARCHAR(255) DEFAULT NULL, ADD climbing_since DATETIME DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL');
		$this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
		$this->addSql('ALTER TABLE user DROP email, DROP first_name, DROP last_name, DROP age, DROP height, DROP weight, DROP phone, DROP climbing_since, CHANGE name name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
	}
}
