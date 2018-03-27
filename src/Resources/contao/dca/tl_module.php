<?php
/**
 * @copyright  MEN AT WORK 2018
 * @package    MenAtWork\SelectModuleBundle
 * @license    GNU/LGPL
 */

/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['selectmodule'] = '{title_legend},name,type;{config_legend},sm_wizard,sm_fallback;{search_legend},sm_searchable;';

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['sm_wizard'] = array
    (
    'label'                             => &$GLOBALS['TL_LANG']['tl_module']['sm_wizard'],
    'exclude'                           => true,
    'inputType'                         => 'multiColumnWizard',
    'eval' => array(
        'columnFields' => array(
            'language' => array(
                'label'                 => &$GLOBALS['TL_LANG']['tl_module']['sm_language'],
                'inputType'             => 'select',
                'options_callback' => function ()
                {
                    return \System::getLanguages();
                },
                'eval'                  => array('mandatory' => true, 'style' => 'width:300px', 'includeBlankOption' => true)
            ),
            'module' => array(
                'label'                 => &$GLOBALS['TL_LANG']['tl_module']['sm_module'],
                'exclude'               => true,
                'inputType'             => 'select',
                'options_callback'      => array('SelectModule_module', 'options_callback'),
                'eval'                  => array('mandatory' => true, 'style' => 'width:300px', 'includeBlankOption' => true)
            ),
        )
    ),
    'sql'                               => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sm_fallback'] = array(
    'label'                             => &$GLOBALS['TL_LANG']['tl_module']['sm_fallback'],
    'exclude'                           => true,
    'inputType'                         => 'checkbox',
    'sql'                               => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sm_searchable'] = array
(
    'label'                             => &$GLOBALS['TL_LANG']['tl_module']['sm_searchable'],
    'exclude'                           => true,
    'inputType'                         => 'checkbox',
    'sql'                               => "char(1) NOT NULL default ''"
);

// Set chosen if we have a contao version 2.11
if(version_compare(VERSION, "2.11", ">="))
{
    $GLOBALS['TL_DCA']['tl_module']['fields']['sm_wizard']['eval']['columnFields']['language']['eval']['chosen'] = true;
	$GLOBALS['TL_DCA']['tl_module']['fields']['sm_wizard']['eval']['columnFields']['module']['eval']['chosen'] = true;
}

class SelectModule_module extends \Backend
{

    public function __construct()
    {
        parent::__construct();
    }

    public function options_callback($objWidget)
    {

        $arrModules = array();

        if (strlen($objWidget->currentRecord) != 0)
        {
            $arrModules =  \Database::getInstance()->prepare("SELECT id, name FROM tl_module WHERE pid=(SELECT pid FROM tl_module WHERE id=?) ORDER BY name asc")->execute($objWidget->currentRecord)->fetchAllAssoc();
	        $arrForms   =  \Database::getInstance()->prepare("SELECT id, title FROM tl_form ORDER BY title asc")->execute($objWidget->currentRecord)->fetchAllAssoc();
        }

        $arrReturn = array();

        foreach ($arrModules as $key => $value)
        {
            $arrReturn[$value["id"].'-module'] = $value["name"];
        }
	
	foreach ($arrForms as $key => $value)
        {
            $arrReturn[$value["id"].'-form'] = $value["title"];
        }

	asort($arrReturn);

        return $arrReturn;
    }
}
?>
