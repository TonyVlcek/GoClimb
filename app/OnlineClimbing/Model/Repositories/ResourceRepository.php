<?php
/**
 * @author Filip Čáp
 */

namespace OnlineClimbing\Model\Repositories;

use OnlineClimbing\Model\Entities\Resource;

class ResourceRepository extends BaseRepository
{

    /**
     * @param string $name
     * @return Resource|NULL
     */
    public function getByName($name)
    {
        return $this->getDoctrineRepository()->findOneBy(['name' => $name]);
    }

}
