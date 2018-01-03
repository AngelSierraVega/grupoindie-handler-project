<?php

/**
 * UnitTest - Tag
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 */

namespace GIndie\UnitTest\Platform\Module\DML;

/**
 * Description of Tag
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @version UT.00.00 17-12-28 Module created
 * @edit UT.00.01
 * - Extended from ClassTestModule
 * - Implemented abstract className()
 * - Added constant NAME
 * @edit UT.00.02 18-01-02
 * - Deprecated class
 */
class Tag extends ClassTestModule
{

    /**
     * 
     * @since UT.00.01
     */
    const NAME = "\GIndie\ScriptGenerator\DML\Node\Tag";

    /**
     * 
     * @since UT.00.01
     * @return string
     */
    protected function className()
    {
        return \GIndie\ScriptGenerator\DML\Node\Tag::class;
    }

}
