<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\UI;

class CdnLinkGenerator
{

	/** @var string */
	private $cdnUrl;


	public function __construct($cdnUrl)
	{
		$this->cdnUrl = $cdnUrl;
	}


	/**
	 * @return string
	 */
	public function getCdnUrl()
	{
		return $this->cdnUrl;
	}


	/**
	 * @param $imageName
	 * @return string
	 */
	public function generateLink($imageName)
	{
		return $this->cdnUrl . $imageName;
	}

}
