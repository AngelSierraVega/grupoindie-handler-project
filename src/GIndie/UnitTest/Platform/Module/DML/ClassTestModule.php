<?php

/**
 * UnitTest - ClassTestModule
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 */

namespace GIndie\UnitTest\Platform\Module\DML;

/**
 * Description of ClassTestModule
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @version UT.00.00 17-12-28 Class created
 * @edit UT.00.01
 * - Abstract class, created abstract method className()
 * - Created method:  widgetReload()
 */
abstract class ClassTestModule extends \GIndie\UnitTest\Platform\Module\AbstractModule
{

    /**
     * 
     * @since UT.00.01
     * @return string
     */
    abstract protected function className();

    /**
     * 
     * @since UT.00.01
     * @return \GIndie\Platform\View\Widget
     */
    protected function widgetReload($id, $class, $selected)
    {
        switch ($id)
        {
            case "ii-i-i":
                $ClassTest = new \GIndie\UnitTest\ClassTest($this->className());
                return new \GIndie\Platform\View\Widget("ClassTest", false, $ClassTest->run());
            default:
                return parent::widgetReload($id, $class, $selected);
        }
    }

}
