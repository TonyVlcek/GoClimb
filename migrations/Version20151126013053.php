<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151126013053 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE company (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE company_user (company_id INT UNSIGNED NOT NULL, user_id INT UNSIGNED NOT NULL, INDEX IDX_CEFECCA7979B1AD6 (company_id), INDEX IDX_CEFECCA7A76ED395 (user_id), PRIMARY KEY(company_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE company_user ADD CONSTRAINT FK_CEFECCA7979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE company_user ADD CONSTRAINT FK_CEFECCA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE wall DROP FOREIGN KEY FK_13F5EFF6A76ED395');
		$this->addSql('DROP INDEX IDX_13F5EFF6A76ED395 ON wall');
		$this->addSql('ALTER TABLE wall CHANGE user_id company_id INT UNSIGNED DEFAULT NULL');
		$this->addSql('ALTER TABLE wall ADD CONSTRAINT FK_13F5EFF6979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
		$this->addSql('CREATE INDEX IDX_13F5EFF6979B1AD6 ON wall (company_id)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE company_user DROP FOREIGN KEY FK_CEFECCA7979B1AD6');
		$this->addSql('ALTER TABLE wall DROP FOREIGN KEY FK_13F5EFF6979B1AD6');
		$this->addSql('DROP TABLE company');
		$this->addSql('DROP TABLE company_user');
		$this->addSql('DROP INDEX IDX_13F5EFF6979B1AD6 ON wall');
		$this->addSql('ALTER TABLE wall CHANGE company_id user_id INT UNSIGNED DEFAULT NULL');
		$this->addSql('ALTER TABLE wall ADD CONSTRAINT FK_13F5EFF6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
		$this->addSql('CREATE INDEX IDX_13F5EFF6A76ED395 ON wall (user_id)');
	}
}
