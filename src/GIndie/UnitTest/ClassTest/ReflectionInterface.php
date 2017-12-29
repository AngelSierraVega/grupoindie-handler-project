<?php

/**
 * UnitTest - ReflectionInterface
 */

namespace GIndie\UnitTest\ClassTest;

/**
 * Description of ReflectionInterface
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 * @version UT.00.00 17-12-28 Interface created
 * @edit UT.00.01 17-12-29
 * - Functional interface.
 * @edit UT.00.02 18-01-01
 * - Added ReflectionCommon functions
 */
interface ReflectionInterface
{

    /**
     * @since UT.00.01
     */
    public function validate();

    /**
     * @since UT.00.01
     */
    public function requiredTags();
    
    /**
     * @since UT.00.02
     */
    public function getTitle();
    
    /**
     * 
     * @since UT.00.02
     * @param type $tagname
     * @param type $colspan
     */
    public function validateTag($tagname, $colspan = "1");
}
