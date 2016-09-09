<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use GoClimb\Model\Enums\AclResource;
use GoClimb\Model\Enums\AclRole;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160908232608 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('ALTER TABLE acl_permission DROP FOREIGN KEY FK_B68D53BF32FB8AEA');
		$this->addSql('DROP TABLE acl_privilege');
		$this->addSql('DROP INDEX IDX_B68D53BF32FB8AEA ON acl_permission');
		$this->addSql('ALTER TABLE acl_permission DROP privilege_id');

		$this->addSql("INSERT INTO `acl_resource` (`name`) VALUES ('" . AclResource::ADMIN_DASHBOARD . "')");
		$this->addSql("INSERT INTO `acl_resource` (`name`) VALUES ('" . AclResource::ADMIN_ARTICLES . "')");
		$this->addSql("INSERT INTO `acl_resource` (`name`) VALUES ('" . AclResource::ADMIN_EVENTS . "')");
		$this->addSql("INSERT INTO `acl_resource` (`name`) VALUES ('" . AclResource::ADMIN_NEWS . "')");
		$this->addSql("INSERT INTO `acl_resource` (`name`) VALUES ('" . AclResource::ADMIN_SETTINGS_ADVANCED . "')");

		$this->addSql("INSERT INTO `acl_role` (`parent_id`, `wall_id`, `name`) VALUES (" . $this->getRoleIdSql(AclRole::GUEST) . ", NULL, '" . AclRole::GOCLIMB_SUPPORT . "')");
		$this->addSql("INSERT INTO `acl_role` (`parent_id`, `wall_id`, `name`) VALUES (" . $this->getRoleIdSql(AclRole::GOCLIMB_SUPPORT) . ", NULL, '" . AclRole::GOCLIMB_ADMIN . "')");
		$this->addSql("INSERT INTO `acl_role` (`parent_id`, `wall_id`, `name`) VALUES (" . $this->getRoleIdSql(AclRole::GOCLIMB_ADMIN) . ", NULL, '" . AclRole::GOCLIMB_OWNER . "')");

		$this->addSql("INSERT INTO `acl_permission` (`role_id`, `resource_id`, `allowed`) VALUES (" . $this->getRoleIdSql(AclRole::GOCLIMB_SUPPORT) . ", " . $this->getResourceIdSql(AclResource::BACKEND_DASHBOARD) . ", 1)");
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql("DELETE FROM `acl_permission` WHERE (`role_id` = " . $this->getRoleIdSql(AclRole::GOCLIMB_SUPPORT) . ") AND (`resource_id` = " . $this->getResourceIdSql(AclResource::BACKEND_DASHBOARD) . ")");

		$this->addSql("DELETE FROM `acl_role` WHERE (`wall_id` IS NULL) AND (`name` = '" . AclRole::GOCLIMB_OWNER . "')");
		$this->addSql("DELETE FROM `acl_role` WHERE (`wall_id` IS NULL) AND (`name` = '" . AclRole::GOCLIMB_ADMIN . "')");
		$this->addSql("DELETE FROM `acl_role` WHERE (`wall_id` IS NULL) AND (`name` = '" . AclRole::GOCLIMB_SUPPORT . "')");

		$this->addSql("DELETE FROM `acl_resource` WHERE (`name` = '" . AclResource::ADMIN_DASHBOARD . "')");
		$this->addSql("DELETE FROM `acl_resource` WHERE (`name` = '" . AclResource::ADMIN_ARTICLES . "')");
		$this->addSql("DELETE FROM `acl_resource` WHERE (`name` = '" . AclResource::ADMIN_EVENTS. "')");
		$this->addSql("DELETE FROM `acl_resource` WHERE (`name` = '" . AclResource::ADMIN_NEWS . "')");
		$this->addSql("DELETE FROM `acl_resource` WHERE (`name` = '" . AclResource::ADMIN_SETTINGS_ADVANCED . "')");

		$this->addSql('CREATE TABLE acl_privilege (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_F025ACB25E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE acl_permission ADD privilege_id INT UNSIGNED NOT NULL');
		$this->addSql('ALTER TABLE acl_permission ADD CONSTRAINT FK_B68D53BF32FB8AEA FOREIGN KEY (privilege_id) REFERENCES acl_privilege (id) ON DELETE CASCADE');
		$this->addSql('CREATE INDEX IDX_B68D53BF32FB8AEA ON acl_permission (privilege_id)');
	}


	private function getRoleIdSql($role)
	{
		return '(SELECT `r`.`id` FROM `acl_role` `r` WHERE `r`.`name` = \'' . $role . '\')';
	}


	private function getResourceIdSql($resource)
	{
		return '(SELECT `e`.`id` FROM `acl_resource` `e` WHERE `e`.`name` = \'' . $resource . '\')';
	}
}
