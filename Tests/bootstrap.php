<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author m.grundner
 */
// TODO: check include path
ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.'C:/xampp/php/PEAR');

include_once dirname(__DIR__).DIRECTORY_SEPARATOR.'HazAClass'.DIRECTORY_SEPARATOR.'System'.DIRECTORY_SEPARATOR.'Autoload.php';

new \HazAClass\System\Autoload('HazAClass', __DIR__.DIRECTORY_SEPARATOR.'HazAClass');

// put your code here
?>
