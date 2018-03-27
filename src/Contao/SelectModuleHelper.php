<?php

namespace MenAtWork\SelectModuleBundle\Contao;
/**
 * @copyright  MEN AT WORK 2018
 * @package    MenAtWork\SelectModuleBundle
 * @license    GNU/LGPL
 */
class SelectModuleHelper extends \Backend
{

    /**
     * Check the required extensions and files for contentflash
     *
     * @param string $strContent
     * @param string $strTemplate
     * @return string
     */
    public function checkExtensions($strContent, $strTemplate)
    {
        if ($strTemplate == 'be_main')
        {
            if (!is_array($_SESSION["TL_INFO"]))
            {
                $_SESSION["TL_INFO"] = array();
            }

            // required extensions
            $arrRequiredExtensions = array(
                'MultiColumnWizard' => 'multicolumnwizard'
            );

            // check for required extensions
            foreach ($arrRequiredExtensions as $key => $val)
            {
                if (!in_array($val, \System::getContainer()->getParameter('kernel.bundles')))
                {
                    $_SESSION["TL_INFO"] = array_merge($_SESSION["TL_INFO"], array($val => 'Please install the required extension <strong>' . $key . '</strong>'));
                }
                else
                {
                    if (is_array($_SESSION["TL_INFO"]) && key_exists($val, $_SESSION["TL_INFO"]))
                    {
                        unset($_SESSION["TL_INFO"][$val]);
                    }
                }
            }
        }

        return $strContent;
    }

}

?>