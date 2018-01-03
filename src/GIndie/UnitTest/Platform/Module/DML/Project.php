<?php

/**
 * UnitTest - Project
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 */

namespace GIndie\UnitTest\Platform\Module\DML;

/**
 * Description of Project
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @version UT.00.00 17-12-28 Module created
 * @edit UT.00.01
 * - Extended from ClassTestModule
 * - Implemented abstract className()
 * - Added constant NAME
 * @edit UT.00.02 18-01-02
 * - Deprecated class
 */
class Project extends \GIndie\UnitTest\Platform\Module\AbstractModule
{

    /**
     * @since UT.00.01
     */
    const NAME = "Project";

    /**
     * @since UT.00.01
     * @return \GIndie\Platform\View\Widget
     */
    protected function widgetReload($id, $class, $selected)
    {
        switch ($id)
        {
            case "ii-i-i":
                return new \GIndie\Platform\View\Widget("Project Test", false, "To do.");
                break;
            default:
                return parent::widgetReload($id, $class, $selected);
        }
    }

}
