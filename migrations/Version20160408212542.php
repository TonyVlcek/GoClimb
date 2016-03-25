<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160408212542 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE wall_translation (id INT UNSIGNED AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE wall ADD logo_id INT UNSIGNED DEFAULT NULL, ADD street VARCHAR(255) DEFAULT NULL, ADD number VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, ADD zip VARCHAR(255) DEFAULT NULL');
		$this->addSql('ALTER TABLE wall ADD CONSTRAINT FK_13F5EFF6F98F144A FOREIGN KEY (logo_id) REFERENCES image (id)');
		$this->addSql('CREATE INDEX IDX_13F5EFF6F98F144A ON wall (logo_id)');
		$this->addSql('ALTER TABLE wall_language ADD wall_translation_id INT UNSIGNED DEFAULT NULL');
		$this->addSql('ALTER TABLE wall_language ADD CONSTRAINT FK_F603DC43FFF89FE FOREIGN KEY (wall_translation_id) REFERENCES wall_translation (id)');
		$this->addSql('CREATE INDEX IDX_F603DC43FFF89FE ON wall_language (wall_translation_id)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE wall_language DROP FOREIGN KEY FK_F603DC43FFF89FE');
		$this->addSql('DROP TABLE wall_translation');
		$this->addSql('ALTER TABLE wall DROP FOREIGN KEY FK_13F5EFF6F98F144A');
		$this->addSql('DROP INDEX IDX_13F5EFF6F98F144A ON wall');
		$this->addSql('ALTER TABLE wall DROP logo_id, DROP street, DROP number, DROP country, DROP zip');
		$this->addSql('DROP INDEX IDX_F603DC43FFF89FE ON wall_language');
		$this->addSql('ALTER TABLE wall_language DROP wall_translation_id');
	}
}
