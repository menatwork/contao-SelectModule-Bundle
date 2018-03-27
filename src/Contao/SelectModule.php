<?php

namespace MenAtWork\SelectModuleBundle\Contao;
/**
 * @copyright  MEN AT WORK 2018
 * @package    MenAtWork\SelectModuleBundle
 * @license    GNU/LGPL
 */
class SelectModule extends \Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'sm_default';

    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### SELECTMODULE ###';
            $objTemplate->title    = $this->headline;
            $objTemplate->id       = $this->id;
            $objTemplate->link     = $this->name;
            $objTemplate->href     = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate module
     */
    public function compile()
    {
        $strReturn = '';
        $arrData   = deserialize($this->sm_wizard);
        $arrType   = array();

        // The language in the backend is stored in the official way: en_US, ...
        // As part of the url we often use en-US instead.
        $strLanguage = str_replace('-', '_', $GLOBALS['TL_LANGUAGE']);

        foreach ($arrData as $arrValue) {
            if ($strLanguage == $arrValue['language']) {
                $arrType = explode('-', $arrValue['module']);
            }
        }

        if (!$arrType && $this->sm_fallback && $arrData) {
            $arrType = explode('-', $arrData[0]['module']);
        }

        switch ($arrType[1]) {
            case 'module':
                $strReturn .= $this->getFrontendModule($arrType[0]);
                break;

            case 'form':
                $strReturn .= $this->getForm($arrType[0]);
                break;
        }

        $this->Template->searchable = ($this->sm_searchable == 1) ? true : false;
        $this->Template->content    = $strReturn;
    }

}

?>