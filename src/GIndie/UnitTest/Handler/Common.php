<?php

/**
 * UnitTest - Common
 */

namespace GIndie\UnitTest\Handler;

/**
 * Description of Common
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 18-01-03 Trait created.
 * @edit UT.00.01
 * - Added code from GIndie\UnitTest\ClassTest\ReflectionCommon
 * @edit UT.00.02
 * - Added $unitTestResult 
 * - Moved out getTitle(), getDocComments(), validateTag(), $docComments
 * - Moved in validateDocComments()
 * @edit UT.00.03
 * - Added $unitTestCount
 */
trait Common
{
    
    /**
     * The number of unit test executed.
     * 
     * @since UT.00.03
     * @var int 
     */
    public $unitTestCount = 0;

    /**
     * The status of the unit test.
     * 
     * @since UT.00.01
     * @var boolean|null 
     */
    public $unitTestStatus;

    /**
     * The last error of the unit test.
     * 
     * @since UT.00.01
     * @var string|null 
     */
    public $unitTestLastError;

    /**
     * The result of the unit test.
     * 
     * @since UT.00.02
     * @var string|null 
     */
    public $unitTestResult;
    
    /**
     * 
     * @since UT.00.02
     */
    public function validateDocComments()
    {
        \trigger_error("@todo", \E_USER_WARNING);
    }

}
