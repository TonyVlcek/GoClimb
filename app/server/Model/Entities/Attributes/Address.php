<?php

namespace GoClimb\Model\Entities\Attributes;

trait Address
{

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $street;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $number;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $country;

	/**
	 * @var string
	 * @ORM\Column(type="string", nullable=TRUE)
	 */
	private $zip;


	/**
	 * @return string|NULL
	 */
	public function getStreet()
	{
		return $this->street;
	}


	/**
	 * @param string|NULL $street
	 * @return $this
	 */
	public function setStreet($street)
	{
		$this->street = $street;
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getNumber()
	{
		return $this->number;
	}


	/**
	 * @param string|NULL $number
	 * @return $this
	 */
	public function setNumber($number)
	{
		$this->number = $number;
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getCountry()
	{
		return $this->country;
	}


	/**
	 * @param string|NULL $country
	 * @return $this
	 */
	public function setCountry($country)
	{
		$this->country = $country;
		return $this;
	}


	/**
	 * @return string|NULL
	 */
	public function getZip()
	{
		return $this->zip;
	}


	/**
	 * @param string|NULL $zip
	 * @return $this
	 */
	public function setZip($zip)
	{
		$this->zip = $zip;
		return $this;
	}

}
