<?php

/**
 * UnitTest - UnitTest
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 */

namespace GIndie\UnitTest\Platform;

/**
 * Description of UnitTest
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @version UT.00.00 17-12-27 Created class
 * @edit UT.00.01
 * - Added code from Platform/dist/examples
 * @edit UT.00.02 18-01-02
 * - Commented old modules
 */
class UnitTest extends \GIndie\Platform\Instance
{

    /**
     * @since UT.00.01
     */
    const BRAND_NAME = "UnitTest";

    /**
     * @since UT.00.01
     * @edit UT.00.02
     */
    public function config()
    {
        $this->setModule(Module\ScriptGenerator\DML::class, "Script Generator");
//        $this->setModule(Module\DML\Project::class, "DML");
//        $this->setModule(Module\DML\Node::class, "DML");
//        $this->setModule(Module\DML\NodeAbs::class, "DML");
//        $this->setModule(Module\DML\Tag::class, "DML");
//        $this->setModule(Module\DML\TagAbs::class, "DML");
    }

}
