<?php

namespace GIndie\ProjectHandler\Handler;

/**
 * Description of Common
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\UnitTest
 *
 * @since 18-01-03
 * - Added code from GIndie\UnitTest\ClassTest\ReflectionCommon
 * - Added $unitTestResult 
 * - Moved out getTitle(), getDocComments(), validateTag(), $docComments
 * - Moved in validateDocComments()
 * - Added $unitTestCount
 * @version 0A.00
 * @edit 18-05-13
 * - Upgraded file structure and namespace
 * @version 0A.0F
 * @todo
 * - Upgrade/verify structure for A1
 */
trait Common
{

    /**
     * The number of unit test executed.
     * 
     * @since 18-01-03
     * @var int 
     */
    public $unitTestCount = 0;

    /**
     * The status of the unit test.
     * 
     * @since 18-01-03
     * @var boolean|null 
     */
    public $unitTestStatus;

    /**
     * The last error of the unit test.
     * 
     * @since 18-01-03
     * @var string|null 
     */
    public $unitTestLastError;

    /**
     * The result of the unit test.
     * 
     * @since 18-01-03
     * @var string|null 
     */
    public $unitTestResult;

    /**
     * 
     * @since 18-01-03
     */
    public function validateDocComments()
    {
        \trigger_error("@todo", \E_USER_WARNING);
    }

}
