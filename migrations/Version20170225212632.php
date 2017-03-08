<?php

namespace GoClimb\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use GoClimb\Model\Entities\Application;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170225212632 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
	    $this->addSql("INSERT INTO `application` (`wall_id`,`name`, `description`, `token`) VALUES (NULL, 'GoTrack app', 'Mobile application for GoClimb.cz', '" . Application::GO_TRACK_TOKEN . "')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
	    $this->addSql("DELETE FROM `application` WHERE (`token` = '" . Application::GO_TRACK_TOKEN . "')");
    }
}
