<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151130164009 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE image (id INT UNSIGNED AUTO_INCREMENT NOT NULL, content_part_id INT UNSIGNED DEFAULT NULL, file_id INT UNSIGNED NOT NULL, thumbnail_file_id INT UNSIGNED NOT NULL, width INT NOT NULL, height INT NOT NULL, INDEX IDX_C53D045F93EB925F (content_part_id), UNIQUE INDEX UNIQ_C53D045F93CB796C (file_id), UNIQUE INDEX UNIQ_C53D045FB16F1215 (thumbnail_file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F93EB925F FOREIGN KEY (content_part_id) REFERENCES content_part (id)');
		$this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F93CB796C FOREIGN KEY (file_id) REFERENCES file (id)');
		$this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FB16F1215 FOREIGN KEY (thumbnail_file_id) REFERENCES file (id)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DROP TABLE image');
	}
}
