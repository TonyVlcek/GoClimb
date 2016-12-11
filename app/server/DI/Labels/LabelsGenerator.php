<?php
/**
 * @author Martin Mikšík
 */

namespace server\DI\Labels;

use chillerlan\QRCode\Output\QRImage;
use chillerlan\QRCode\QRCode;
use Exception;
use GoClimb\Model\Entities\Boulder;
use GoClimb\Model\Entities\Rope;
use GoClimb\Model\Entities\Route;
use GoClimb\UI\CdnLinkGenerator;
use Latte\Engine;
use Nette\Application\IResponse;
use Nette\Application\LinkGenerator;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\Http;
use Wkhtmltopdf\Document;
use Wkhtmltopdf\Page;


class LabelsGenerator implements IResponse
{

	/** @var LinkGenerator */
	private $linkGenerator;

	/** @var CdnLinkGenerator */
	private $cdnLinkGenerator;

	/** @var QRCode */
	private $qrGenerator;

	/** @var Engine */
	private $latteEngine;

	/** @var Rope[] */
	private $ropes = [];

	/** @var Boulder[] */
	private $boulders = [];

	/** @var int */
	private $pageZoom;

	/** @var string */
	private $tempDir;


	/**
	 * LabelsGenerator constructor.
	 *
	 * @param int $pageZoom
	 * @param string $tempDir
	 * @param LinkGenerator $linkGenerator
	 * @param CdnLinkGenerator $cdnLinkGenerator
	 * @param ILatteFactory $ILatteFactory
	 */
	public function __construct($pageZoom, $tempDir, LinkGenerator $linkGenerator, CdnLinkGenerator $cdnLinkGenerator, ILatteFactory $ILatteFactory)
	{
		$this->pageZoom = $pageZoom;
		$this->linkGenerator = $linkGenerator;
		$this->cdnLinkGenerator = $cdnLinkGenerator;
		$this->tempDir = $tempDir;
		$this->latteEngine = $ILatteFactory->create();

		$outputInterface = new QRImage();
		$this->qrGenerator = new QRCode('Invalid qr code', $outputInterface);
	}


	public function addRope(Route $rope)
	{
		$this->ropes[] = $rope;
	}


	public function addBoulder(Route $boulder)
	{
		$this->boulders[] = $boulder;
	}


	public function send(Http\IRequest $httpRequest, Http\IResponse $httpResponse)
	{
		if (count($this->boulders) <= 0 && count($this->ropes) <= 0) {
			throw new Exception('Can not create empty pdf');
		}

		$document = new Document($this->tempDir);
		$document->dpi = 72;
		$document->size = 'A4';
		$document->title = 'Labels - GoClimb';
		$path = __DIR__ . '/resources/';

		if (count($this->ropes) > 0) {
			$page = new Page;
			$page->zoom = $this->pageZoom;
			$page->encoding = 'UTF-8';
			$css = '<style>' . file_get_contents($path . 'StyleRope.css') . '</style>';
			$page->html = $css . $this->latteEngine->renderToString($path . 'Rope.latte', ['cdn' => $this->getCdn(), 'getQR' => $this->getQR(), 'ropes' => $this->ropes]);
			$document->addPart($page);
		}

		if (count($this->boulders) > 0) {
			$page = new Page;
			$page->zoom = $this->pageZoom;
			$page->encoding = 'UTF-8';
			$css = '<style>' . file_get_contents($path . 'StyleBoulder.css') . '</style>';
			$page->html = $css . $this->latteEngine->renderToString($path . 'Boulder.latte', ['cdn' => $this->getCdn(), 'getQR' => $this->getQR(), 'boulders' => $this->boulders]);
			$document->addPart($page);
		}

		$document->send($httpRequest, $httpResponse);
	}


	private function getCdn()
	{
		return function ($name) {
			return $this->cdnLinkGenerator->generateLink($name);
		};
	}


	private function getQR()
	{
		return function ($id) {
			//You need to set Local, otherwise it won't work!
			return $this->qrGenerator->setData($this->linkGenerator->link('Rest:V1:Qr:default', ['id' => $id, 'locale' => 'en']))->output();
		};
	}

}
