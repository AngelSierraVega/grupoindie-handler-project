<?php

/**
 * UnitTest - ClassTest
 */

namespace GIndie\UnitTest;

/**
 * Performs a Unit-Test on a given class.
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 * 
 * @version GI.00.01 17-05-18 New class.
 * @version GI-CMMN.00.00 17-12-24 New project GICommon.
 * @edit GI-CMMN.00.01
 * - Sources from external project SG-DML
 * @edit GI-CMMN.00.02
 * - Moved class, renamed class, implements GIInterface
 * - Display error when not implementing a method defined in the class.
 * @edit GI-CMMN.00.03
 * - Created method's: validateDocCommentMethod(), handleMethod()
 * - Updated constructor. Using ReflectionClass to validate a class
 * 
 * @version UT.00.00 17-12-25 New project UnitTest
 * - Created dummie class
 * - Added functions from external project GICommon
 * - Removed abstract from original class.
 * - Removed implementation of interface.
 * @edit UT.00.01
 * - Updated run(), __construct()
 * - Created $reflectionClass
 * @edit UT.00.02
 * - Updated run(), validateDocCommentMethod()
 * @edit UT.00.03
 * - Deleted validateDocCommentMethod(), added code to validateMethod()
 * - Updated validateMethod()
 * - Created validateClass(), validateMethods()
 * - trait ToUpgrade used. Moved methods execExceptionCmp(), execStrCmp()
 * - trait ToDeprecate used.
 * @edit UT.00.04 17-12-28
 * - Added var $testTitle
 * - Added method: readClassProperties(), validateClassDocComments(), 
 * - Updated method: __construct()
 * @edit UT.00.05
 * - Added var: $docComments, $requiredClassTags
 * - Added method: getTableData()
 * - Updated method: validateClassDocComments()
 * @edit UT.00.06 Use new class \GIndie\UnitTest\ClassTest\Reflection
 * - Moved out method: readClassProperties(), validateClassDocComments(), getTableData() 
 * - Moved out method: validateMethod()
 * - Moved out var: $requiredClassTags, $docComments, $testTitle
 * - Update var: $reflectionClass
 * - Updated method: __construct()
 */
class ClassTest
{

    /**
     * @since UT.00.03
     */
    use \GIndie\UnitTest\ClassTest\ToUpgrade;
    use \GIndie\UnitTest\ClassTest\ToDeprecate;

    /**
     * 
     * @since UT.00.01
     * @edit UT.00.06
     * @var \GIndie\UnitTest\ClassTest\ReflectionClass Stores the ReflectionClass object that handles the class.
     */
    private $reflectionClass;

    /**
     * Runs the user defined functions. Implementation of a singleton pattern for Test class.
     * 
     * @since GI.00.01
     * 
     * @return string
     * 
     * @edit UT.00.01
     * - Moved funcionality from constructor
     * - Removed visibility static
     * - Use $reflectionClass 
     * @edit UT.00.02
     * - Added output buffering insted of echo.
     * - Method returns string.
     * @edit UT.00.03
     * - Use validateClass(), validateMethods()
     * @edit UT.00.06
     */
    public function run()
    {
        return $this->validateClass();
    }

    /**
     * Stores the ReflectionClass for handling.
     * 
     * @final
     * @since GI.00.01
     * 
     * @param string $classname The name of the class (including namespace) to be handled.
     * 
     * @edit UT.00.01
     * - Visivility changed to public. Added parameter $classname
     * - Moved functionality to run()
     * - Removed deprecated functionality
     * - Use $reflectionClass 
     * @edit UT.00.04
     * - Use var testTitle
     * @edit UT.00.06
     * - Update reflectionClass
     */
    final public function __construct($classname)
    {
        $this->reflectionClass = new ClassTest\ReflectionClass($classname);
        
    }
    
    /**
     * @since UT.00.06
     * @return string
     */
    public function getTitle()
    {
        return $this->reflectionClass->getTitle();
    }

    /**
     * Executes a class validation
     * 
     * @since UT.00.03
     * 
     * @return string
     * @edit UT.00.06
     */
    private function validateClass()
    {
        $out = $this->reflectionClass->validateProperties();
        $out .= $this->reflectionClass->validateDocComments();
        $out .= $this->reflectionClass->validateMethods();
        return $out;
    }

}
