<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160221051330 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE language (id INT UNSIGNED AUTO_INCREMENT NOT NULL, shortcut VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, const VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE wall_language (id INT UNSIGNED AUTO_INCREMENT NOT NULL, wall_id INT UNSIGNED NOT NULL, language_id INT UNSIGNED NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_F603DC43C33923F1 (wall_id), INDEX IDX_F603DC4382F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE wall_language ADD CONSTRAINT FK_F603DC43C33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id)');
		$this->addSql('ALTER TABLE wall_language ADD CONSTRAINT FK_F603DC4382F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
		$this->addSql('DROP INDEX UNIQ_13F5EFF69E103BE4 ON wall');
		$this->addSql('ALTER TABLE wall ADD primary_language_id INT UNSIGNED DEFAULT NULL, DROP base_url');
		$this->addSql('ALTER TABLE wall ADD CONSTRAINT FK_13F5EFF6261EDA75 FOREIGN KEY (primary_language_id) REFERENCES wall_language (id)');
		$this->addSql('CREATE UNIQUE INDEX UNIQ_13F5EFF6261EDA75 ON wall (primary_language_id)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE wall_language DROP FOREIGN KEY FK_F603DC4382F1BAF4');
		$this->addSql('ALTER TABLE wall DROP FOREIGN KEY FK_13F5EFF6261EDA75');
		$this->addSql('DROP TABLE language');
		$this->addSql('DROP TABLE wall_language');
		$this->addSql('DROP INDEX UNIQ_13F5EFF6261EDA75 ON wall');
		$this->addSql('ALTER TABLE wall ADD base_url VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP primary_language_id');
		$this->addSql('CREATE UNIQUE INDEX UNIQ_13F5EFF69E103BE4 ON wall (base_url)');
	}
}
