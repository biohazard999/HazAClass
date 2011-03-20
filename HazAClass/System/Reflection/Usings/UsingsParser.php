<?php

namespace HazAClass\System\Reflection\Usings;

use HazAClass\System\Object;
use HazAClass\System\Collection\ArrayList;
use HazAClass\System\Collection\IList;

class UsingsParser extends Object
{
	/**
	 *
	 * @var \Reflection
	 */
	private $ref;

	public function __construct(\ReflectionClass $ref)
	{
		$this->ref = $ref;
	}

	/**
	 * @return IList
	 */
	public function GetUsings()
	{
		return $this->parseUsings();
	}

	protected function parseUsings()
	{
		$usingTokenParts = token_get_all(file_get_contents($this->ref->getFileName()));

		$usingTokenParts = $this->filterTokens($usingTokenParts);

		$usings = new ArrayList();
		foreach($usingTokenParts as $token)
		{
			if($this->hasAlias($token))
				$alias = $this->getAlias($token);
			else
				$alias = $this->getResolvedClassname($token);
			$usings[$alias] = $this->getFullQualifiedClassname($token);
		}

		return $usings;
	}

	private function filterTokens($tokens)
	{
		$collect = false;
		$collected = array();
		$i = -1;
		foreach($tokens as $token)
		{
			if(is_int($token[0]))
			{
				if($token[0] == \T_USE)
				{
					$i++;
					$collect = true;
					continue;
				}

				if($collect)
					switch($token[0])
					{
						case \T_STRING:
						case \T_NS_SEPARATOR:
						case \T_AS: {
								$token[3] = token_name($token[0]);
								$collected[$i][] = $token;
								break;
							}
					}
			}
			elseif($token === ';')
				$collect = false;
			elseif($token === ',' && $collect)
				$i++;
		}
		return $collected;
	}

	private function hasAlias($tokens)
	{
		foreach($tokens as $token)
			if($token[0] === \T_AS)
				return true;
		return false;
	}

	private function getAlias($tokens)
	{
		return $tokens[count($tokens) - 1][1];
	}

	private function getResolvedClassname($tokens)
	{
		return $tokens[count($tokens) - 1][1];
	}

	private function getFullQualifiedClassname($tokens)
	{
		$classname = '';
		foreach($tokens as $token)
		{
			switch($token[0])
			{
				case \T_NS_SEPARATOR:
				case \T_STRING:
					$classname .= $token[1];
					break;
				case \T_AS:
					return $classname;
			}
		}
		return $classname;
	}
}

?>
