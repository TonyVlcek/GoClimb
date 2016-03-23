<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160308220226 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE acl_permission (id INT UNSIGNED AUTO_INCREMENT NOT NULL, role_id INT UNSIGNED NOT NULL, resource_id INT UNSIGNED NOT NULL, privilege_id INT UNSIGNED NOT NULL, allowed TINYINT(1) NOT NULL, INDEX IDX_B68D53BFD60322AC (role_id), INDEX IDX_B68D53BF89329D25 (resource_id), INDEX IDX_B68D53BF32FB8AEA (privilege_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE user_role (acl_role_id INT UNSIGNED NOT NULL, user_id INT UNSIGNED NOT NULL, INDEX IDX_2DE8C6A3BD33296F (acl_role_id), INDEX IDX_2DE8C6A3A76ED395 (user_id), PRIMARY KEY(acl_role_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE acl_permission ADD CONSTRAINT FK_B68D53BFD60322AC FOREIGN KEY (role_id) REFERENCES acl_role (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE acl_permission ADD CONSTRAINT FK_B68D53BF89329D25 FOREIGN KEY (resource_id) REFERENCES acl_resource (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE acl_permission ADD CONSTRAINT FK_B68D53BF32FB8AEA FOREIGN KEY (privilege_id) REFERENCES acl_privilege (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3BD33296F FOREIGN KEY (acl_role_id) REFERENCES acl_role (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE user_role ADD CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DROP TABLE acl_permission');
		$this->addSql('DROP TABLE user_role');
	}
}
