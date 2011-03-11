<?php

/** ********************************************************************************************************$
 * $Id:: AttributesParser.php 4 2010-11-06 12:37:02Z manuelgrundner                                         $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/attributes/AttributesParser.#$
 ********************************************************************************************************** */

namespace HazAClass\System\Attributes;

use HazAClass\core\parser\iParser;
use HazAClass\utils\StringUtil;
use HazAClass\utils\StringTrimUtil;

class AttributesParser implements iParser
{

    public static $classname = __CLASS__;

    public function parse($docblock)
    {
        $docblock = StringUtil::remove($docblock, AttributeTokenizer::T_STAR_COMMENT_BEGIN);
        $docblock = StringUtil::remove($docblock, AttributeTokenizer::T_STAR_COMMENT_END);
        $docblock = StringUtil::remove($docblock, AttributeTokenizer::T_STAR);
        $docblock = StringTrimUtil::trim($docblock);
		return $docblock;
    }

}
?>
