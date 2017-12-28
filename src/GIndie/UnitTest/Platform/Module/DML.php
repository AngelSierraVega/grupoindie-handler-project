<?php

/**
 * UnitTest - DML
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * 
 */

namespace GIndie\UnitTest\Platform\Module;

/**
 * Description of DML
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version UT.00.00 17-12-27 Class created.
 * @edit UT.00.01
 * - Added code from Platform/dist/examples
 */
class DML extends AbstractModule
{

    /**
     * @since UT.00.01
     */
    const NAME = "DML";

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
