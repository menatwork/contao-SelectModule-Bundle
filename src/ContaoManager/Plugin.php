<?php
/**
 * @copyright  MEN AT WORK 2018
 * @package    MenAtWork\SelectModuleBundle
 * @license    GNU/LGPL
 */

namespace MenAtWork\SelectModuleBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Config\ConfigInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use MenAtWork\SelectModuleBundle\SelectModuleBundle;

/**
 * Class Plugin
 *
 * @package MenAtWork\SelectModuleBundle\ContaoManager
 */
class Plugin implements BundlePluginInterface
{

    /**
     * @param ParserInterface $parser
     *
     * @return array|ConfigInterface[]
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(SelectModuleBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['contao-legacy/selectmodule'])
                ->setReplace(['menatwork/selectmodule']),
        ];
    }
}