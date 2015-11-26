<?php
/**
 * @author Tony Vlček
 */

namespace OnlineClimbing\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use OnlineClimbing\Model\Entities\Attributes\Id;


/**
 * @ORM\Entity
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_order_page", columns={"order", "page_id"})})
 */
class ContentPart
{

	use Id;

	/**
	 * @var Page
	 * @ORM\ManyToOne(targetEntity="Page", inversedBy="contentParts")
	 * @ORM\JoinColumn(nullable=FALSE)
	 */
	private $page;

	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	private $content;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	private $type;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	private $order;


	/**
	 * @return Page
	 */
	public function getPage()
	{
		return $this->page;
	}


	/**
	 * @param Page $page
	 * @return $this
	 */
	public function setPage(Page $page)
	{
		$this->page = $page;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}


	/**
	 * @param string $content
	 * @return $this
	 */
	public function setContent($content)
	{
		$this->content = $content;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getType()
	{
		return $this->type;
	}


	/**
	 * @param int $type
	 * @return $this
	 */
	public function setType($type)
	{
		$this->type = $type;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getOrder()
	{
		return $this->order;
	}


	/**
	 * @param int $order
	 * @return $this
	 */
	public function setOrder($order)
	{
		$this->order = $order;
		return $this;
	}

}
