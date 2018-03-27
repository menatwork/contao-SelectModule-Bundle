<?php
/**
 * @copyright  MEN AT WORK 2018
 * @package    MenAtWork\SelectModuleBundle
 * @license    GNU/LGPL
 */
 
/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['miscellaneous']['selectmodule'] = 'MenAtWork\\SelectModuleBundle\\Contao\\SelectModule';

/*
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = array('MenAtWork\\SelectModuleBundle\\Contao\\SelectModuleHelper', 'checkExtensions');

?>
