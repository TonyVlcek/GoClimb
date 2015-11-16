<?php

namespace OnlineClimbing\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151115223539 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE role (id INT UNSIGNED AUTO_INCREMENT NOT NULL, parent_id INT UNSIGNED DEFAULT NULL, wall_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_57698A6A727ACA70 (parent_id), INDEX IDX_57698A6AC33923F1 (wall_id), UNIQUE INDEX unique_name_wall (name, wall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE wall (id INT UNSIGNED AUTO_INCREMENT NOT NULL, user_id INT UNSIGNED DEFAULT NULL, INDEX IDX_13F5EFF6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6A727ACA70 FOREIGN KEY (parent_id) REFERENCES role (id)');
		$this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6AC33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id)');
		$this->addSql('ALTER TABLE wall ADD CONSTRAINT FK_13F5EFF6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6A727ACA70');
		$this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6AC33923F1');
		$this->addSql('DROP TABLE role');
		$this->addSql('DROP TABLE wall');
	}
}
