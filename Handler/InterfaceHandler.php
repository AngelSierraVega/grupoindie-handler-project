<?php

namespace GIndie\ProjectHandler\Handler;

/**
 * Description of InterfaceHandler
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package ProjectHandler
 *
 * @since 18-01-03
 * @edit 18-01-03
 * - Added code from GIndie\UnitTest\ClassTest\ReflectionInterface
 * - Updated interface
 * - Moved out methods.
 * @version A0.00
 * @edit 18-05-13
 * - Upgraded file structure and namespace
 * @version 0A.0F
 * @todo
 * - Upgrade/verify structure for A1
 */
interface InterfaceHandler
{

    /**
     * 
     * @since 18-01-03
     */
    public function execUnitTest();

    /**
     * @since 18-01-03
     */
    public function formattedTitle();

    /**
     * @since 18-01-03
     */
    public function validateDocComments();
}
