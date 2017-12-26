<?php

/**
 * UnitTest - ClassTest
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 */

namespace GIndie\UnitTest;

/**
 * Performs a Unit-Test on a given class.
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version GI.00.17-05-18
 * @version GI-CMMN.00.17-12-24
 * @edit 01
 * - Sources from external project SG-DML
 * @edit 02
 * - Moved class, renamed class, implements GIInterface
 * - Display error when not implementing a method defined in the class.
 * @edit 03
 * - Created method's: validateDocCommentMethod(), handleMethod()
 * - Updated constructor. Using ReflectionClass to validate a class
 * @version UT.00.17-12-25
 * - Created dummie class
 * - Added functions from external project GICommon
 * - Removed abstract from original class.
 * - Removed implementation of interface.
 */
class ClassTest
{

    /**
     * 
     * @param \ReflectionMethod $Method
     * @since GI-CMMN.00.17-12-24.03
     */
    private static function validateDocCommentMethod(\ReflectionMethod $Method)
    {
        echo "<span style=\"font-size: 1.1em; font-weight: bolder;\">" . $Method->name . " </span><br>";
        $comment = \GIndie\Common\Parser\DocComment::parseFromString($Method->getDocComment());
        switch (true)
        {
            case $Method->isConstructor():
                break;
            default:
                if (isset($comment["return"])) {
                    echo "<span style=\"font-size: 0.9em;\">@return " . $comment["return"] . "</span><br>";
                } else {
                    echo "<span style=\"color:red;\">@return tag must be commented</span><br>";
                }
                break;
        }
    }

    /**
     * 
     * @param \ReflectionMethod $Method
     * @since GI-CMMN.00.17-12-24.03
     */
    private function handleMethod($filename, \ReflectionMethod $Method)
    {
        switch ($filename)
        {
            case $Method->getFileName():
                static::validateDocCommentMethod($Method);
                break;
        }
    }

    /**
     * @final
     * @since GI.00.17-05-18
     * @edit GI-CMMN.00.17-12-24.03
     */
    final private function __construct()
    {
        echo "<div style=\"font-size: 1.4em;\">------------ " .
        \get_called_class() .
        "</div>\n";
        $ignoreFunctions = \get_class_methods(__CLASS__);
        $testFunctions = \get_class_methods(\get_called_class());

        $reflector = new \ReflectionClass($this->classname());
        foreach ($reflector->getMethods() as $ReflectionMethod) {//ReflectionMethod::IS_PROTECTED
            $this->handleMethod($reflector->getFileName(), $ReflectionMethod);
        }
        foreach (\get_class_methods($this->classname()) as $method) {
            switch (false)
            {
                case (\strcmp($method, "__toString") != 0):
                    break;
                case \in_array($method, $testFunctions):
                //echo "<span style=\"color:red; font-weight: bolder;\"'>" . $method . " must be declared in UnitTestClass</span><br>";
            }
        }
//        foreach ($testFunctions as $function) {
//            \in_array($function, $ignoreFunctions) ?: static::{$function}();
//        }
    }

    /**
     * 
     * Execute a string comparing test.
     * @static
     * 
     * @param string $expected The expected output.
     * @param string $result The code that generates the expected output.
     * 
     * @since GI.00.17-05-18
     */
    public static function execStrCmp($expected, $result)
    {
        echo "<div style = \"font-size: 1.1em;\">" .
        \debug_backtrace()[1]['function'] . "::";
        switch (\strcmp($expected, $result))
        {
            case 0:
                echo "<span style=\"color: green; font-weight: bolder;\">Passed</span></div>";
                break;
            default:
                echo "<span style=\"color:red; font-weight: bolder;\"'>Error:</span></div>";
                echo "<br/><span style=\"font-size: 1.05em;\">Expected:</span><pre>" .
                \htmlentities($expected) . "</pre>" .
                "<span style=\"font-size: 1.05em;\">Resutl:</span><pre>" . \htmlentities($result) .
                "</pre><br />\n <------------------------>";
                break;
        }
    }

    /**
     * 
     * Execute a string comparing test.
     * @static
     * 
     * @param \Exception $exception The exception to be compared.
     * 
     * @since GI-CMMN.00.17-12-24
     */
    public static function execExceptionCmp(\Exception $exception = null)
    {
        echo "<div style=\"font-size: 1.1em;\">" .
        \debug_backtrace()[1]['function'] . "::";
        switch (true)
        {
            case \is_null($exception):
                echo "<span style=\"color:red; font-weight: bolder;\"'>Error</span></div>";
                break;
            default:
                echo "<span style=\"color: green; font-weight: bolder;\">Passed (exception thrown) ";
                echo "</span>";
                echo $exception->getMessage();
                echo "</div>";
                break;
        }
    }

    /**
     * Runs the user defined functions. Implementation of a singleton pattern for Test class.
     * 
     * @since GI.00.17-05-18
     */
    public static function run()
    {
        new static();
    }

}
