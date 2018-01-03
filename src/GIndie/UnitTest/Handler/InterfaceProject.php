<?php

/**
 * UnitTest - InterfaceProject
 */

namespace GIndie\UnitTest\Handler;

/**
 * Description of InterfaceProject
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 * @version UT.00.00 18-01-03 Interface created.
 * @edit UT.00.01
 * - Added code from UnitTest\HandlerProject.php
 */
interface InterfaceProject
{

    /**
     * 
     * @since UT.00.01
     */
    public static function projectClasses();

    /**
     * 
     * @since UT.00.01
     */
    public static function projectName();

    /**
     * 
     * @since UT.00.01
     */
    public static function projectNamespace();

    /**
     * 
     * @since UT.00.01
     */
    public static function projectVendor();
}
