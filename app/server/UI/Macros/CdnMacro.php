<?php
/**
 * @author Tomáš Blatný
 */

namespace GoClimb\UI\Macros;

use Latte\Compiler;
use Latte\Macros\MacroSet;


class CdnMacro
{

	public static function install(Compiler $compiler)
	{
		$set = new MacroSet($compiler);
		$set->addMacro('cdn', NULL, NULL, 'echo "src=\\"" . $cdn(%node.word) . "\\""');
	}

}
