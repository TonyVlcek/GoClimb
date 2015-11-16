<?php
/**
 * @author Filip Čáp
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use OnlineClimbing\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 */
class Resource
{

    use Id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=FALSE, unique=TRUE)
     */
    private $name;


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}
