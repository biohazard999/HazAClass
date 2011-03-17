<?php
/** * *******************************************************************************************************$
 * $Id:: Tokens.php 4 2010-11-06 12:37:02Z manuelgrundner                                                   $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-06 13:37:02 +0100 (Sa, 06 Nov 2010)                                           $
 * $LastChangedRevision:: 4                                                                                 $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/tokenizer/Tokens.php         $
 * ********************************************************************************************************* */

namespace HazAClass\System\Parser\Token;

use HazAClass\System\Collection\Generic\GenericList;
use HazAClass\System\Object;

class Tokens extends Object
{

	public static $classname = __CLASS__;
	/**
	 * @var GenericList
	 */
	private $tokens;
	private $position = 0;
	private $peak = 0;
	private $currentToken;

	public function __construct()
	{
		$this->tokens = new GenericList(Token::$classname);
	}

	public function SetPosition($position)
	{
		$this->position = $position;
		if($this->tokens->IndexExists($position))
			$this->currentToken = $this->tokens[$position];
	}

	public function AddToken(Token $token)
	{
		$this->tokens[] = $token;
	}

	public function GetTokens()
	{
		return $this->tokens;
	}

	public function IsA($type)
	{
		return $this->tokens[$this->position]->isA($type);
	}

	public function IsNextTokenA($type)
	{
		if($this->HasNext())
			return $this->GetNextToken()->isA($type);
		return false;
	}

	public function GetNextTokenType()
	{
		return $this->peak()->getId();
	}

	public function GetCurrentTokenType()
	{
		return $this->GetCurrentToken()->getId();
	}

	public function MoveNext()
	{
		$this->resetPeak();
		$this->position++;
		$this->GetCurrentToken();
	}

	public function HasNext()
	{
		return $this->tokens->IndexExists($this->position + 1);
	}

	public function SkipUntil($type)
	{
		if($this->GetCurrentToken()->IsA($type))
			return $this->GetCurrentToken();
		
		while($this->HasNext())
		{
			if($this->GetCurrentToken()->IsA($type))
				return $this->GetCurrentToken();
			$this->MoveNext();
		}
	}

	public function PeakUntil($type)
	{
		if($this->Peak()->IsA($type))
			return $this->getCurrentPeak();

		$this->PeakUntilNext($type);
	}

	public function PeakUntilNext($type)
	{
		while(!$this->GetCurrentPeak()->IsA($type))
			$this->Peak();
	}

	public function SkipUntilNext($type)
	{
		while(!$this->IsNextTokenA($type))
			$this->MoveNext();
	}

	public function Rewind()
	{
		$this->setPosition(0);
	}

	public function ResetPeak()
	{
		$this->peak = 0;
	}

	/**
	 * @return Token
	 */
	public function Peak()
	{
		$this->peak = $this->peak + 1;
		return $this->GetCurrentPeak();
	}

	/**
	 * @return Token
	 */
	public function GetCurrentPeak()
	{
		return $this->tokens[$this->GetPeakedPosition()];
	}

	public function GetPeakedPosition()
	{
		return $this->position + $this->peak;
	}

	/**
	 * @return Token
	 */
	public function GetCurrentToken()
	{
		$this->currentToken = $this->tokens[$this->position];
		return $this->currentToken;
	}

	/**
	 * @param int $i = 1
	 * @return Token
	 */
	public function GetNextToken($i = 1)
	{
		return $this->tokens[$this->position + 1];
	}

}

?>
