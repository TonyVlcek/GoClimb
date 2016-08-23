<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160823150616 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DROP INDEX UNIQ_8D93D6495E237E06 ON user');
		$this->addSql('ALTER TABLE user CHANGE name nick VARCHAR(255) DEFAULT NULL');
		$this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649290B2F37 ON user (nick)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DROP INDEX UNIQ_8D93D649290B2F37 ON user');
		$this->addSql('ALTER TABLE user CHANGE nick name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
		$this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495E237E06 ON user (name)');
	}
}
