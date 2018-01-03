<?php

/**
 * UnitTest - InterfaceHandler
 */

namespace GIndie\UnitTest\Handler;

/**
 * Description of InterfaceHandler
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 18-01-03 Interface created.
 * @edit UT.00.01
 * - Added code from GIndie\UnitTest\ClassTest\ReflectionInterface
 * @edit UT.00.02
 * - Updated interface
 * - Moved out methods.
 */
interface InterfaceHandler
{

    /**
     * 
     * @since UT.00.02
     */
    public function execUnitTest();

    /**
     * @since UT.00.01
     */
    public function formattedTitle();
    
    /**
     * @since UT.00.01
     * @edit UT.00.02
     */
    public function validateDocComments();
}
