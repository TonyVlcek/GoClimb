<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160911210553 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE post (id INT UNSIGNED AUTO_INCREMENT NOT NULL, wall_id INT UNSIGNED DEFAULT NULL, author_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, published_date DATETIME DEFAULT NULL, content LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, INDEX IDX_5A8A6C8DC33923F1 (wall_id), INDEX IDX_5A8A6C8DF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DC33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id)');
		$this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
		$this->addSql('DROP TABLE article');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE article (id INT UNSIGNED AUTO_INCREMENT NOT NULL, wall_id INT UNSIGNED DEFAULT NULL, author_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, published DATETIME DEFAULT NULL, content LONGTEXT NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_23A0E66C33923F1 (wall_id), INDEX IDX_23A0E66F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id)');
		$this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
		$this->addSql('DROP TABLE post');
	}
}
