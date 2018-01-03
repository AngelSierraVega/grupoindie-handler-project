<?php

/**
 * UnitTest - HandlerProject
 */

namespace GIndie\UnitTest;

/**
 * Description of HandlerProject
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 18-01-03 Class created.
 * @edit UT.00.01
 * - Interface implemented with dummie methods.
 * - Use trait
 * - Defined abstract projectClasses(), projectNamespace(), projectVendor()
 */
abstract class HandlerProject implements Handler\InterfaceHandler
{

    /**
     * 
     * @since UT.00.01
     */
    use Handler\Common;

    /**
     * 
     * @since UT.00.01
     */
    abstract public function projectClasses();
    
    /**
     * 
     * @since UT.00.01
     */
    abstract public function projectNamespace();
    
    /**
     * 
     * @since UT.00.01
     */
    abstract public function projectVendor();

    /**
     * 
     * @since UT.00.01
     * @return void
     */
    public function execUnitTest()
    {
        \trigger_error("@todo", \E_USER_WARNING);
    }

    /**
     * 
     * @since UT.00.01
     * @return string
     */
    public function formattedTitle()
    {
        \trigger_error("@todo", \E_USER_WARNING);
    }

}
