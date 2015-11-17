<?php

namespace OnlineClimbing\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151117144809 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE user_favorite_wall (user_id INT UNSIGNED NOT NULL, wall_id INT UNSIGNED NOT NULL, INDEX IDX_137D5B99A76ED395 (user_id), INDEX IDX_137D5B99C33923F1 (wall_id), PRIMARY KEY(user_id, wall_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE user_favorite_wall ADD CONSTRAINT FK_137D5B99A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE user_favorite_wall ADD CONSTRAINT FK_137D5B99C33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id) ON DELETE CASCADE');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DROP TABLE user_favorite_wall');
	}
}
