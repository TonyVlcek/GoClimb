<?php

namespace OnlineClimbing\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151117001636 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6A727ACA70 FOREIGN KEY (parent_id) REFERENCES role (id)');
		$this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6AC33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id)');
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

		$this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6A727ACA70');
		$this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6AC33923F1');
		$this->addSql('DROP INDEX UNIQ_13F5EFF65E237E06 ON wall');
		$this->addSql('ALTER TABLE wall DROP name');
	}
}
