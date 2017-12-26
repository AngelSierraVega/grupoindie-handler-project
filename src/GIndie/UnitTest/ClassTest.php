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
 */
class ClassTest
{

    /**
     * 
     * @since UT.00.01
     * @var \ReflectionClass Stores the ReflectionClass object that handles the class.
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
     */
    public function run()
    {
        ob_start();
        ?>
        <div style="font-size: 1.4em;">
            Class: <?= $this->reflectionClass->getName(); ?>
        </div>
        <?php
        foreach ($this->reflectionClass->getMethods() as $ReflectionMethod) {//ReflectionMethod::IS_PROTECTED
            $this->handleMethod($this->reflectionClass->getFileName(), $ReflectionMethod);
        }
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
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
     */
    final public function __construct($classname)
    {
        $this->reflectionClass = new \ReflectionClass($classname);
    }

    /**
     * 
     * @since GI-CMMN.00.03
     * 
     * @param \ReflectionMethod $Method
     * 
     * @edit UT.00.02
     * - Added output buffering insted of echo.
     */
    private static function validateDocCommentMethod(\ReflectionMethod $Method)
    {
        $comment = \GIndie\Common\Parser\DocComment::parseFromString($Method->getDocComment());
        \ob_start();
        ?>
        <span style="font-size: 1.1em; font-weight: bolder;"><?= $Method->name; ?></span><br>
        <?php
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
        $out = \ob_get_contents();
        \ob_end_clean();
        echo $out;
    }

    /**
     * 
     * @param \ReflectionMethod $Method
     * @since GI-CMMN.00.03
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
     * 
     * Execute a string comparing test.
     * @static
     * 
     * @param string $expected The expected output.
     * @param string $result The code that generates the expected output.
     * 
     * @since GI.00.01
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
     * @since GI-CMMN.00.01
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

}
