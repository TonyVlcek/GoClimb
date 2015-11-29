<?php

namespace OnlineClimbing\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151129145259 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE application (id INT UNSIGNED AUTO_INCREMENT NOT NULL, wall_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A45BDDC15F37A13B (token), UNIQUE INDEX UNIQ_A45BDDC1C33923F1 (wall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE login_token (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED NOT NULL, token VARCHAR(255) NOT NULL, expiration DATETIME NOT NULL, UNIQUE INDEX UNIQ_594766AF5F37A13B (token), INDEX IDX_594766AFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1C33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id)');
		$this->addSql('ALTER TABLE login_token ADD CONSTRAINT FK_594766AFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DROP TABLE application');
		$this->addSql('DROP TABLE login_token');
	}
}
