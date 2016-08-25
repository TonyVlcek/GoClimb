<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151117003903 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE wall ADD name VARCHAR(255) NOT NULL');
		$this->addSql('CREATE UNIQUE INDEX UNIQ_13F5EFF65E237E06 ON wall (name)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DROP INDEX UNIQ_13F5EFF65E237E06 ON wall');
		$this->addSql('ALTER TABLE wall DROP name');
	}
}
