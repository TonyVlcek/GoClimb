<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use GoClimb\Model\Enums\AclResource;
use GoClimb\Model\Enums\Parameter;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160922134354 extends AbstractMigration
{
	/**
	 * @param Schema $schema
	 */
	public function up(Schema $schema)
	{
		// this up() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('CREATE TABLE difficulty (id INT UNSIGNED AUTO_INCREMENT NOT NULL, rating_uiaa VARCHAR(255) DEFAULT NULL, rating_frl VARCHAR(255) DEFAULT NULL, rating_hueco VARCHAR(255) DEFAULT NULL, rating_frb VARCHAR(255) DEFAULT NULL, points INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE route_parameter (id INT UNSIGNED AUTO_INCREMENT NOT NULL, route_id INT UNSIGNED NOT NULL, parameter_id INT UNSIGNED NOT NULL, level INT NOT NULL, INDEX IDX_86D5441834ECB4E6 (route_id), INDEX IDX_86D544187C56DBD6 (parameter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE route_color (route_id INT UNSIGNED NOT NULL, color_id INT UNSIGNED NOT NULL, INDEX IDX_FB297A4734ECB4E6 (route_id), INDEX IDX_FB297A477ADA1FB5 (color_id), PRIMARY KEY(route_id, color_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE parameter (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2A9791105E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE color (id INT UNSIGNED AUTO_INCREMENT NOT NULL, wall_id INT UNSIGNED DEFAULT NULL, hash VARCHAR(255) NOT NULL, INDEX IDX_665648E9C33923F1 (wall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
		$this->addSql('ALTER TABLE route_parameter ADD CONSTRAINT FK_86D5441834ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
		$this->addSql('ALTER TABLE route_parameter ADD CONSTRAINT FK_86D544187C56DBD6 FOREIGN KEY (parameter_id) REFERENCES parameter (id)');
		$this->addSql('ALTER TABLE route_color ADD CONSTRAINT FK_FB297A4734ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE route_color ADD CONSTRAINT FK_FB297A477ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE');
		$this->addSql('ALTER TABLE color ADD CONSTRAINT FK_665648E9C33923F1 FOREIGN KEY (wall_id) REFERENCES wall (id)');
		$this->addSql('ALTER TABLE route ADD difficulty_id INT UNSIGNED NOT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD date_created DATETIME DEFAULT NULL, ADD date_removed DATETIME DEFAULT NULL, ADD type VARCHAR(255) NOT NULL, ADD length INT DEFAULT NULL, ADD steps INT DEFAULT NULL, ADD start VARCHAR(255) DEFAULT NULL, ADD end VARCHAR(255) DEFAULT NULL');
		$this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079FCFA9DAE FOREIGN KEY (difficulty_id) REFERENCES difficulty (id)');
		$this->addSql('CREATE INDEX IDX_2C42079FCFA9DAE ON route (difficulty_id)');

		$this->addSql('INSERT INTO `acl_resource` (`name`) VALUES (\'' . AclResource::ADMIN_ROUTES_BOULDER . '\')');
		$this->addSql('INSERT INTO `acl_resource` (`name`) VALUES (\'' . AclResource::ADMIN_ROUTES_ROPE . '\')');

		$this->addSql($this->getAddColorsSql([
			'#969696',
			'#753f16',
			'#8c05ad',
			'#ff7105',
			'#ebb48a',
			'#ffffff',
			'#ff0d0d',
			'#f7ff00',
			'#bdff47',
			'#0dff0d',
			'#ff19d1',
			'#057aff',
			'#0a0a0a',
		]));

		$this->addDifficulties();

		$this->addSql('INSERT INTO `parameter` (`name`) VALUES (\'' . Parameter::SIDE_FACE . '\')');
		$this->addSql('INSERT INTO `parameter` (`name`) VALUES (\'' . Parameter::STRENGTH . '\')');
		$this->addSql('INSERT INTO `parameter` (`name`) VALUES (\'' . Parameter::TECHNIQUE . '\')');
		$this->addSql('INSERT INTO `parameter` (`name`) VALUES (\'' . Parameter::ENDURANCE . '\')');
		$this->addSql('INSERT INTO `parameter` (`name`) VALUES (\'' . Parameter::BOULDER . '\')');
		$this->addSql('INSERT INTO `parameter` (`name`) VALUES (\'' . Parameter::KNOW_HOW . '\')');
		$this->addSql('INSERT INTO `parameter` (`name`) VALUES (\'' . Parameter::KEY_POINTS . '\')');
		$this->addSql('INSERT INTO `parameter` (`name`) VALUES (\'' . Parameter::BULGE . '\')');
		$this->addSql('INSERT INTO `parameter` (`name`) VALUES (\'' . Parameter::SMALL_HANDLES . '\')');
	}

	/**
	 * @param Schema $schema
	 */
	public function down(Schema $schema)
	{
		// this down() migration is auto-generated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

		$this->addSql('DELETE FROM `acl_resource` WHERE (`name` = \'' . AclResource::ADMIN_ROUTES_ROPE . '\')');
		$this->addSql('DELETE FROM `acl_resource` WHERE (`name` = \'' . AclResource::ADMIN_ROUTES_BOULDER . '\')');

		$this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079FCFA9DAE');
		$this->addSql('ALTER TABLE route_parameter DROP FOREIGN KEY FK_86D544187C56DBD6');
		$this->addSql('ALTER TABLE route_color DROP FOREIGN KEY FK_FB297A477ADA1FB5');
		$this->addSql('DROP TABLE difficulty');
		$this->addSql('DROP TABLE route_parameter');
		$this->addSql('DROP TABLE route_color');
		$this->addSql('DROP TABLE parameter');
		$this->addSql('DROP TABLE color');
		$this->addSql('DROP INDEX IDX_2C42079FCFA9DAE ON route');
		$this->addSql('ALTER TABLE route DROP difficulty_id, DROP description, DROP date_created, DROP date_removed, DROP type, DROP length, DROP steps, DROP start, DROP end');
	}


	private function getAddColorsSql(array $colors)
	{
		$values = '(NULL, \'' . implode('\'), (NULL, \'', $colors) . '\')';
		return 'INSERT INTO `color` (`wall_id`, `hash`) VALUES ' . $values;
	}


	private function addDifficulties()
	{
		// rope
		$this->addSql('INSERT INTO `difficulty` (`rating_uiaa`, `rating_frl`, `rating_hueco`, `rating_frb`, `points`) VALUES ' .
			'(\'1\', \'1\', NULL, NULL, 10),' .
			'(\'2\', \'2\', NULL, NULL, 20),' .
			'(\'3-\', \'3-\', NULL, NULL, 25),' .
			'(\'3\', \'3\', NULL, NULL, 30),' .
			'(\'3+\', \'3+\', NULL, NULL, 35),' .
			'(\'4-\', \'4a\', NULL, NULL, 50),' .
			'(\'4\', \'4b\', NULL, NULL, 100),' .
			'(\'4+\', \'4c\', NULL, NULL, 150),' .
			'(\'5-\', \'4c\', NULL, NULL, 175),' .
			'(\'5\', \'5a\', NULL, NULL, 200),' .
			'(\'5+\', \'5a\', NULL, NULL, 225),' .
			'(\'6-\', \'5b\', NULL, NULL, 250),' .
			'(\'6\', \'5c\', NULL, NULL, 300),' .
			'(\'6\', \'5c\', NULL, NULL, 300),' .
			'(\'6+\', \'5c+\', NULL, NULL, 350),' .
			'(\'6+/7-\', \'6a\', NULL, NULL, 400),' .
			'(\'7-\', \'6a+\', NULL, NULL, 450),' .
			'(\'7-/7\', \'6a+/6b\', NULL, NULL, 475),' .
			'(\'7\', \'6b\', NULL, NULL, 500),' .
			'(\'7/7+\', \'6b/6b+\', NULL, NULL, 525),' .
			'(\'7+\', \'6b+\', NULL, NULL, 550),' .
			'(\'7+\', \'6b+/6c\', NULL, NULL, 575),' .
			'(\'7+/8-\', \'6c\', NULL, NULL, 600),' .
			'(\'8-\', \'6c/6c+\', NULL, NULL, 625),' .
			'(\'8-\', \'6c+\', NULL, NULL, 650),' .
			'(\'8-/8\', \'6c+/7a\', NULL, NULL, 675),' .
			'(\'8\', \'7a\', NULL, NULL, 700),' .
			'(\'8/8+\', \'7a/7a+\', NULL, NULL, 725),' .
			'(\'8+\', \'7a+\', NULL, NULL, 750),' .
			'(\'8+\', \'7a+/7b\', NULL, NULL, 775),' .
			'(\'8+/9-\', \'7b\', NULL, NULL, 800),' .
			'(\'9-\', \'7b/7b+\', NULL, NULL, 825),' .
			'(\'9-\', \'7b+\', NULL, NULL, 850),' .
			'(\'9-/9\', \'7b+/7c\', NULL, NULL, 875),' .
			'(\'9\', \'7c\', NULL, NULL, 900),' .
			'(\'9/9+\', \'7c/7c+\', NULL, NULL, 925),' .
			'(\'9+\', \'7c+\', NULL, NULL, 950),' .
			'(\'9+\', \'7c+/8a\', NULL, NULL, 975),' .
			'(\'9+/10-\', \'8a\', NULL, NULL, 1000),' .
			'(\'10-\', \'8a/8a+\', NULL, NULL, 1025),' .
			'(\'10-\', \'8a+\', NULL, NULL, 1050),' .
			'(\'10-/10\', \'8a+/8b\', NULL, NULL, 1075),' .
			'(\'10\', \'8b\', NULL, NULL, 1100),' .
			'(\'10/10+\', \'8b/8b+\', NULL, NULL, 1125),' .
			'(\'10+\', \'8b+\', NULL, NULL, 1150),' .
			'(\'10+/11-\', \'8b+/8c\', NULL, NULL, 1175),' .
			'(\'11-\', \'8c\', NULL, NULL, 1200),' .
			'(\'11-\', \'8c/8c+\', NULL, NULL, 1225),' .
			'(\'11-/11\', \'8c+\', NULL, NULL, 1250),' .
			'(\'11-/11\', \'8c+/9a\', NULL, NULL, 1275),' .
			'(\'11\', \'9a\', NULL, NULL, 1300),' .
			'(\'11/11+\', \'9a/9a+\', NULL, NULL, 1325),' .
			'(\'11+\', \'9a+\', NULL, NULL, 1350),' .
			'(\'11+/12-\', \'9a+/9b\', NULL, NULL, 1375),' .
			'(\'12-\', \'9b\', NULL, NULL, 1400),' .
			'(\'12-/12\', \'9b/9b+\', NULL, NULL, 1425),' .
			'(\'12\', \'9b+\', NULL, NULL, 1450)');

		$this->addSql('INSERT INTO `difficulty` (`rating_uiaa`, `rating_frl`, `rating_hueco`, `rating_frb`, `points`) VALUES ' .
			'(NULL, NULL, \'v0\', \'3+\', 300), ' .
			'(NULL, NULL, \'v0\', \'4\', 350), ' .
			'(NULL, NULL, \'v0\', \'4+\', 400), ' .
			'(NULL, NULL, \'v1\', \'5\', 450), ' .
			'(NULL, NULL, \'v2\', \'5+\', 500), ' .
			'(NULL, NULL, \'v3\', \'6a\', 550), ' .
			'(NULL, NULL, \'v3\', \'6a+\', 600), ' .
			'(NULL, NULL, \'v4\', \'6b\', 650), ' .
			'(NULL, NULL, \'v4\', \'6b+\', 700), ' .
			'(NULL, NULL, \'v5\', \'6c\', 750), ' .
			'(NULL, NULL, \'v6\', \'6c+\', 800), ' .
			'(NULL, NULL, \'v7\', \'7a\', 850), ' .
			'(NULL, NULL, \'v7\', \'7a+\', 900), ' .
			'(NULL, NULL, \'v8\', \'7b\', 950), ' .
			'(NULL, NULL, \'v8\', \'7b+\', 1000), ' .
			'(NULL, NULL, \'v9\', \'7c\', 1050), ' .
			'(NULL, NULL, \'v10\', \'7c+\', 1100), ' .
			'(NULL, NULL, \'v11\', \'8a\', 1150)');

	}

}
