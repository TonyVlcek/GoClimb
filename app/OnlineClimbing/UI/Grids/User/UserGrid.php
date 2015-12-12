<?php
/**
 * @author Tomáš Blatný
 */

namespace OnlineClimbing\UI\Grids\User;

use Nette\Forms\Container;
use OnlineClimbing\Model\Query\Specifications\AndArgs;
use OnlineClimbing\Model\Query\Specifications\OrderBy;
use OnlineClimbing\Model\Query\Specifications\User\NameLike;
use OnlineClimbing\Model\Repositories\UserRepository;
use OnlineClimbing\UI\Grids\BaseGrid;
use OnlineClimbing\UI\Grids\ITranslatableGridFactory;


interface IUserGridFactory extends ITranslatableGridFactory
{

	/** @return UserGrid */
	function create();

}


class UserGrid extends BaseGrid
{


	/** @var UserRepository */
	private $userRepository;


	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
		parent::__construct();
	}


	public function init()
	{
		$this->addColumn('id', 'fields.id');
		$this->addColumn('name', 'fields.name')->enableSort();
	}


	/**
	 * @inheritdoc
	 */
	public function getQueryBuilder($filters, $order)
	{
		$args = new AndArgs;
		if (isset($filters['name'])) {
			$args->add(new NameLike($filters['name']));
		}

		return $this->userRepository->getBuilderByFilters(
			$args,
			new OrderBy($order)
		);
	}


	/**
	 * @inheritdoc
	 */
	public function getDomain()
	{
		return 'user';
	}


	/**
	 * @inheritdoc
	 */
	public function getFilterForm()
	{
		$form = new Container;
		$form->addText('name')
			->setAttribute('placeholder', 'filter.name');
		return $form;
	}

}
