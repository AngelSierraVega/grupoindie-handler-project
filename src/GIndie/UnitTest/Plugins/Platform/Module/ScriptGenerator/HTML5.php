<?php

/**
 * UnitTest - HTML5
 */

namespace GIndie\UnitTest\Plugins\Platform\Module\ScriptGenerator;

/**
 * Description of HTML5
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 18-01-03 Class created
 * @edit UT.00.01
 * - Implemented module
 */
class HTML5 extends \GIndie\UnitTest\Plugins\Platform\Module\AbstractModule
{
    
    /**
     * 
     * @since UT.00.01
     */
    const NAME = "SG-HTML5";

    /**
     * @since UT.00.01
     * @return string
     */
    protected function projectUnitTest()
    {
        return \GIndie\ScriptGenerator\HTML5\Plugins\UnitTest\HandlerProject::class;
    }

}
