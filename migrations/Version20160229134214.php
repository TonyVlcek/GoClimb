<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160229134214 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		$this->addSql('INSERT INTO `language` (`shortcut`, `name`, `const`) VALUES (\'en\', \'English\', \'english\')');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		$this->addSql('DELETE FROM `language` WHERE (`shortcut` = \'en\')');
	}
}
