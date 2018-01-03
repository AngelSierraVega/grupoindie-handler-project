<?php

/**
 * UnitTest - AbstractModule
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * 
 */

namespace GIndie\UnitTest\Plugins\Platform\Module;

/**
 * Description of AbstractModule
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version UT.00.00 17-12-27 Class created.
 * @edit UT.00.01
 * - Added code from Platform/dist/examples
 * @edit UT.00.02 18-01-02
 * - Implemented project test
 * @edit UT.00.03 18-01-03
 * - Moved out code to UnitTest\HandlerProject
 * - Handle context widget
 */
abstract class AbstractModule extends \GIndie\Platform\Controller\Module
{

    /**
     * 
     * @since UT.00.01
     * @return array
     */
    public static function RequiredRoles()
    {
        return ["AS"];
    }

    /**
     * @since UT.00.01
     */
    public function config()
    {
        $this->configPlaceholder("i-i-i")->typeHTMLString("");
        $this->configPlaceholder("ii-i-i")->typeHTMLString("THIS MUST NOT APPEAR");
    }

    /**
     * 
     * @since UT.00.02
     * @return string
     */
    abstract protected function projectUnitTest();

    /**
     * 
     * @since UT.00.02
     * @return \GIndie\Platform\View\Widget
     * @edit UT.00.03
     */
    protected function widgetReload($id, $class, $selected)
    {
        switch ($id)
        {
            case "ii-i-i":
                $HandlerClass = new \GIndie\UnitTest\HandlerClass($this->projectUnitTest());
                $HandlerClass = $HandlerClass->newInstanceArgs();
                $HandlerClass->execUnitTest();
                
                $widget = new \GIndie\Platform\View\Widget($HandlerClass->formattedTitle(), false, $HandlerClass->unitTestResult);
                if($HandlerClass->unitTestStatus === true){
                    $widget->setContext("success");
                }else{
                    $widget->setContext("warning");
                }
                return $widget;
            default:
                return parent::widgetReload($id, $class, $selected);
        }
    }

}
