<?php

/**
 * UnitTest - ReflectionInterface
 */

namespace GIndie\UnitTest\Handler;

/**
 * Description of ReflectionInterface
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 18-01-03 Interface created.
 * @edit UT.00.01
 * - Moved in methods.
 */
interface ReflectionInterface
{

    /**
     * 
     * @since UT.00.01
     */
    public function getDocComments();

    /**
     * @since UT.00.01
     */
    public function requiredTags();
    
    /**
     * 
     * @since UT.00.01
     * @param type $tagname
     * @param type $colspan
     */
    public function validateTag($tagname, $colspan = "1");
    
}
