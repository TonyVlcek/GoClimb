<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160302185401 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE login_token ADD long_term TINYINT(1) NOT NULL');
		$this->addSql('ALTER TABLE wall DROP INDEX UNIQ_13F5EFF6261EDA75, ADD INDEX IDX_13F5EFF6261EDA75 (primary_language_id)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE login_token DROP long_term');
		$this->addSql('ALTER TABLE wall DROP INDEX IDX_13F5EFF6261EDA75, ADD UNIQUE INDEX UNIQ_13F5EFF6261EDA75 (primary_language_id)');
	}
}
