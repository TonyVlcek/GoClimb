<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151212222745 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6A727ACA70');
		$this->addSql('CREATE TABLE acl_privilege (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F025ACB25E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE acl_resource (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_BE9757175E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE acl_role (id INT UNSIGNED AUTO_INCREMENT NOT NULL, parent_id INT UNSIGNED DEFAULT NULL, wall_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_7065EB79727ACA70 (parent_id), INDEX IDX_7065EB79C33923F1 (wall_id), UNIQUE INDEX unique_name_wall (name, wall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE acl_role ADD CONSTRAINT FK_7065EB79727ACA70 FOREIGN KEY (parent_id) REFERENCES acl_role (id)');
		$this->addSql('ALTER TABLE acl_role ADD CONSTRAINT FK_7065EB79C33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id)');
		$this->addSql('DROP TABLE privilege');
		$this->addSql('DROP TABLE resource');
		$this->addSql('DROP TABLE role');
		$this->addSql('CREATE UNIQUE INDEX UNIQ_59F777775F37A13B ON rest_token (token)');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE acl_role DROP FOREIGN KEY FK_7065EB79727ACA70');
		$this->addSql('CREATE TABLE privilege (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_87209A875E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE resource (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_BC91F4165E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE role (id INT UNSIGNED AUTO_INCREMENT NOT NULL, parent_id INT UNSIGNED DEFAULT NULL, wall_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX unique_name_wall (name, wall_id), INDEX IDX_57698A6A727ACA70 (parent_id), INDEX IDX_57698A6AC33923F1 (wall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6A727ACA70 FOREIGN KEY (parent_id) REFERENCES role (id)');
		$this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6AC33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id)');
		$this->addSql('DROP TABLE acl_privilege');
		$this->addSql('DROP TABLE acl_resource');
		$this->addSql('DROP TABLE acl_role');
		$this->addSql('DROP INDEX UNIQ_59F777775F37A13B ON rest_token');
	}
}
