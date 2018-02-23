<?php

/**
 * UnitTest - HTML5form
 */

namespace GIndie\UnitTest\Plugins\Platform\Module\ScriptGenerator;

/**
 * Description of HTML5form
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
class HTML5form extends \GIndie\UnitTest\Plugins\Platform\Module\AbstractModule
{
    
    /**
     * 
     * @since UT.00.01
     */
    const NAME = "SG-HTML5form";

    /**
     * @since UT.00.01
     * @return string
     */
    protected function projectUnitTest()
    {
        return \GIndie\ScriptGenerator\HTML5\Plugins\UnitTest\HandlerProjectHTML5form::class;
    }

}
