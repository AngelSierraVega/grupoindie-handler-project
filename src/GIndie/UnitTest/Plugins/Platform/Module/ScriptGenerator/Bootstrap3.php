<?php

/**
 * UnitTest - Bootstrap3
 */

namespace GIndie\UnitTest\Plugins\Platform\Module\ScriptGenerator;

/**
 * Description of Bootstrap3
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 18-01-18 Empty class created.
 * @edit UT.00.01
 * - Functional module
 */
class Bootstrap3 extends \GIndie\UnitTest\Plugins\Platform\Module\AbstractModule
{
    
    /**
     * 
     * @since UT.00.01
     */
    const NAME = "SG-Bootstrap3";

    /**
     * @since UT.00.01
     * @return string
     */
    protected function projectUnitTest()
    {
        return \GIndie\ScriptGenerator\Bootstrap3\Plugins\UnitTest\HandlerProject::class;
    }

}

