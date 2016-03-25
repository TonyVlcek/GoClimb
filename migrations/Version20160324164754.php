<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use GoClimb\Model\Entities\Application;
use GoClimb\Model\Enums\AclPrivilege;
use GoClimb\Model\Enums\AclResource;
use GoClimb\Model\Enums\AclRole;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160324164754 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		$this->addSql("INSERT INTO `application` (`wall_id`,`name`, `description`, `token`) VALUES (NULL, 'GoClimb.cz administration', 'An internal administration for GoClimb.cz service.', '" . Application::BACKEND_TOKEN . "')");
		$this->addSql("INSERT INTO `acl_role` (`parent_id`, `wall_id`, `name`) VALUES (NULL, NULL, '" . AclRole::GUEST . "')");
		$this->addSql("INSERT INTO `acl_resource` (`name`) VALUES ('" . AclResource::BACKEND_DASHBOARD . "')");
		$this->addSql("INSERT INTO `acl_privilege` (`name`) VALUES ('" . AclPrivilege::READ . "')");
		$this->addSql("INSERT INTO `acl_privilege` (`name`) VALUES ('" . AclPrivilege::WRITE . "')");
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		$this->addSql("DELETE FROM `acl_privilege` WHERE (`name` = '" . AclPrivilege::WRITE . "')");
		$this->addSql("DELETE FROM `acl_privilege` WHERE (`name` = '" . AclPrivilege::READ . "')");
		$this->addSql("DELETE FROM `acl_resource` WHERE (`name` = '" . AclResource::BACKEND_DASHBOARD . "')");
		$this->addSql("DELETE FROM `acl_role` WHERE (`wall_id` IS NULL) AND (`name` = '" . AclRole::GUEST . "')");
		$this->addSql("DELETE FROM `application` WHERE (`token` = '" . Application::BACKEND_TOKEN . "')");
	}
}
