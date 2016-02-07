<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\Routing;

interface IFilter
{

	/**
	 * @return array
	 */
	function getFilterDefinition();


	/**
	 * @param array $params
	 * @return array
	 */
	function in(array $params);


	/**
	 * @param array $params
	 * @return array
	 */
	function out(array $params);

}
