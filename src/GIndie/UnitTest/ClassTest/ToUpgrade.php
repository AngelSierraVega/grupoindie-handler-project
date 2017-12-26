<?php

/**
 * UnitTest - ToUpgrade
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 */

namespace GIndie\UnitTest\ClassTest;

/**
 * Collection of methods in need of upgrade. Deprecated marker until upgraded.
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @version UT.00.00 17-12-26 Trait created
 * - Added execExceptionCmp(), execStrCmp()
 */
trait ToUpgrade
{

    /**
     * 
     * Execute a string comparing test.
     * 
     * @param \Exception $exception The exception to be compared.
     * @since GI-CMMN.00.01
     * @deprecated since UT.00.00
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
     * 
     * Execute a string comparing test.
     * 
     * @param string $expected The expected output.
     * @param string $result The code that generates the expected output.
     * 
     * @since GI.00.01
     * @deprecated since UT.00.00
     * 
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

}
