<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use GoClimb\Model\Enums\AclResource;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160926210452 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		$this->addSql("INSERT INTO `acl_resource` (`name`) VALUES ('" . AclResource::ADMIN_ACL . "')");
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		$this->addSql("DELETE FROM `acl_resource` WHERE (`name` = '" . AclResource::ADMIN_ACL . "')");
	}

}
