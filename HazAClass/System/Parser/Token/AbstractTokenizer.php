<?php

/** ********************************************************************************************************$
 * $Id:: AbstractTokenizer.php 4 2010-11-06 12:37:02Z manuelgrundner                                        $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 *********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 ******************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-06 13:37:02 +0100 (Sa, 06 Nov 2010)                                           $
 * $LastChangedRevision:: 4                                                                                 $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/tokenizer/AbstractTokenizer.#$
 ********************************************************************************************************** */

namespace HazAClass\System\Parser\Token;

use HazAClass\System\Object;

abstract class AbstractTokenizer extends Object implements ITokenizer
{

    public static $classname = __CLASS__;

    private $tokens;

	private $createLeftTokenReferences = false;
    public function __construct()
    {
        $this->tokens = new Tokens();
		$this->createLeftTokenReferences = false;
    }

    protected function CreateTokenIfIsUnderstandable($id, $value, $linenumber)
    {
        if(!$this->IsUnderstandableToken($id))
            return;

        $token = new Token($id, $value, $linenumber);

        $this->tokens->addToken($token);
    }

    abstract protected function IsUnderstandableToken($token);
	abstract protected function ModifyIDBeforeCreating($id,$value);
	abstract protected function ModifyValueBeforeCreating($id, $value);

	private function InternalModifyIDBeforeCreating($id,$value)
	{
		$orgId = $id;
		$modId = $this->ModifyIDBeforeCreating($id,$value);

		if($modId === null)
			return $orgId;
		return $modId;
	}

	private function InternalModifyValueBeforeCreating($id, $value)
	{
		$orgValue = $value;
		$modValue = $this->ModifyValueBeforeCreating($id, $value);

		if($modValue === null)
			return $orgValue;
		return $modValue;
	}

    public function Tokenize($input)
    {
        $phpTokens = token_get_all($input);

        foreach($phpTokens as $phpToken)
        {
			$id = null;
			$value = null;
			$line = null;
            if(is_array($phpToken))
			{
				$id = $this->InternalModifyIDBeforeCreating($phpToken[0], $phpToken[1]);
				$value = $this->InternalModifyValueBeforeCreating($id, $phpToken[1]);
				$line = $phpToken[2];

			}
            else
			{
				$id = $this->InternalModifyIDBeforeCreating($phpToken, $phpToken);
				$value = $this->InternalModifyValueBeforeCreating($id, $phpToken);
			}

			$this->CreateTokenIfIsUnderstandable($id, $value, $line);
        }
		return $this->tokens;
    }

    public function GetTokens()
    {
        return $this->tokens;
    }

}
?>
