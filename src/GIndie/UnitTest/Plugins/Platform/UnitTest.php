<?php

/**
 * UnitTest - UnitTest
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 */

namespace GIndie\UnitTest\Plugins\Platform;

/**
 * Description of UnitTest
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @version UT.00.00 17-12-27 Created class
 * @edit UT.00.01
 * - Added code from Platform/dist/examples
 * @edit UT.00.02 18-01-02
 * - Commented old modules
 * @edit UT.00.03 18-01-03
 * - Added module for HTML5
 */
class UnitTest extends \GIndie\Platform\Instance
{

    /**
     * @since UT.00.01
     */
    const BRAND_NAME = "UnitTest";

    /**
     * @since UT.00.01
     * @edit UT.00.03
     */
    public function config()
    {
        $this->setModule(Module\ScriptGenerator\DML::class, "Script Generator");
        $this->setModule(Module\ScriptGenerator\HTML5::class, "Script Generator");
    }

}
