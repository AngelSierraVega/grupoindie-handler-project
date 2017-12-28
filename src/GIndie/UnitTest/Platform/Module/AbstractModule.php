<?php

/**
 * UnitTest - AbstractModule
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * 
 */

namespace GIndie\UnitTest\Platform\Module;

/**
 * Description of AbstractModule
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version UT.00.00 17-12-27 Class created.
 * @edit UT.00.01
 * - Added code from Platform/dist/examples
 */
abstract class AbstractModule extends \GIndie\Platform\Controller\Module
{

    /**
     * 
     * @since UT.00.01
     * @return array
     */
    public static function RequiredRoles()
    {
        return ["AS"];
    }

    /**
     * @since UT.00.01
     */
    public function config()
    {
        $this->configPlaceholder("i-i-i")->typeHTMLString("");
        $this->configPlaceholder("ii-i-i")->typeHTMLString("THIS MUST NOT APPEAR");
    }

}
