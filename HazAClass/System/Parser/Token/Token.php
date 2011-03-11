<?php
/** ********************************************************************************************************$
 * $Id:: Token.php 4 2010-11-06 12:37:02Z manuelgrundner                                                    $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/tokenizer/Token.php          $
 ********************************************************************************************************** */

namespace HazAClass\System\Parser\Token;

use HazAClass\System\Object;

class Token extends Object
{

    public static $classname = __CLASS__;
    private $id;
    private $value;
    private $linenumber;
    private $name;

    public function __construct($id, $value, $linenumber)
    {
        $this->id = $id;
		$this->SetTokenName($id);
        $this->value = $value;
        $this->linenumber = $linenumber;
    }

	private function SetTokenName($id)
	{
		if(is_numeric($id))
			$this->name = token_name($id);
		else
			$this->name = $id;
	}

    public function GetValue()
    {
        return $this->value;
    }

    public function GetLinenumber()
    {
        return $this->linenumber;
    }

    public function GetId()
    {
        return $this->id;
    }

    public function IsA($id)
    {
        return $this->id === $id;
    }

    public function ToString()
    {
        return $this->tokenName;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function SetName($name)
    {
        $this->name = $name;
    }

}
?>
