<?php

/**
 * UnitTest - DML
 */

namespace GIndie\UnitTest\Plugins\Platform\Module\ScriptGenerator;

/**
 * Description of DML
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 18-01-02 Class created.
 * @edit UT.00.01
 * - Extend class from \GIndie\UnitTest\Platform\Module\AbstractModule.
 * - Implemented extention methods.
 */
class DML extends \GIndie\UnitTest\Plugins\Platform\Module\AbstractModule
{

    /**
     * 
     * @since UT.00.01
     */
    const NAME = "SG-DML";

    /**
     * @since UT.00.01
     * @return string
     */
    protected function projectUnitTest()
    {
        return \GIndie\ScriptGenerator\DML\Plugins\UnitTest\HandlerProject::class;
    }

}
