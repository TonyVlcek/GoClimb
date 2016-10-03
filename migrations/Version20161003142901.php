<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use GoClimb\Model\Enums\Style;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161003142901 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE style (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, rope_points INT DEFAULT NULL, boulder_points INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE log (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED NOT NULL, route_id INT UNSIGNED NOT NULL, style_id INT UNSIGNED DEFAULT NULL, logged_date DATETIME NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_8F3F68C5A76ED395 (user_id), INDEX IDX_8F3F68C534ECB4E6 (route_id), INDEX IDX_8F3F68C5BACD6074 (style_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
		$this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C534ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
		$this->addSql('ALTER TABLE log ADD CONSTRAINT FK_8F3F68C5BACD6074 FOREIGN KEY (style_id) REFERENCES style (id)');

		$this->addSql('INSERT INTO `style` (`name`, `rope_points`, `boulder_points`) VALUES (\'' . Style::OS . '\', 122, 53);');
		$this->addSql('INSERT INTO `style` (`name`, `rope_points`, `boulder_points`) VALUES (\'' . Style::FLASH . '\', 53, 53);');
		$this->addSql('INSERT INTO `style` (`name`, `rope_points`, `boulder_points`) VALUES (\'' . Style::PP2 . '\', 6, 6);');
		$this->addSql('INSERT INTO `style` (`name`, `rope_points`, `boulder_points`) VALUES (\'' . Style::PPN . '\', 0, 0);');
		$this->addSql('INSERT INTO `style` (`name`, `rope_points`, `boulder_points`) VALUES (\'' . Style::SOLO . '\', NULL, 0);');
		$this->addSql('INSERT INTO `style` (`name`, `rope_points`, `boulder_points`) VALUES (\'' . Style::AF . '\', 1, 1);');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE log DROP FOREIGN KEY FK_8F3F68C5BACD6074');
		$this->addSql('DROP TABLE style');
		$this->addSql('DROP TABLE log');
	}
}
