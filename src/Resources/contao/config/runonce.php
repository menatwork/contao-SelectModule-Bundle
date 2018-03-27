<?php
/**
 * @copyright  MEN AT WORK 2018
 * @package    MenAtWork\SelectModuleBundle
 * @license    GNU/LGPL
 */
class SelectModuleRunonce extends \Controller
{

    /**
     * SelectModuleRunonce constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        $objModules = \Database::getInstance()
                ->prepare('SELECT id, sm_wizard FROM tl_module WHERE type = \'selectmodule\'')
                ->execute();

        while($row = $objModules->fetchAssoc())
        {
            $tmp = deserialize($row['sm_wizard'], true);

            foreach ($tmp as $k => $v)
            {
                if (is_numeric($v['module']))
                {
                    $tmp[$k]['module'] = $v['module'].'-module';
                }
            }

            \Database::getInstance()
                    ->prepare('UPDATE tl_module SET sm_wizard = ? WHERE id = ?')
                    ->execute(serialize($tmp), $row['id']);
        }
	}
}

$objSelectModuleRunonce = new SelectModuleRunonce();
$objSelectModuleRunonce->run();
