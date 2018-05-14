<?php

namespace GIndie;

/**
 * ProjectHandler
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package ProjectHandler
 *
 * @since 18-02-23
 * @edit 18-02-23
 * - Abstract class
 * - Implemented ProjectHandlerInterface
 * @edit 18-02-24
 * - Updated autoloaderFilename()
 * @edit 18-03-27
 * - Added excludeFromPhar();
 * @version A0.00
 * @edit 18-05-13
 * - Moved class from external project GI-Common
 * - Class implements ProjectHandler\Handler\InterfaceHandler and ProjectHandler\Handler\InterfaceProject
 * @version A0.F0
 */
abstract class ProjectHandler implements ProjectHandler\ProjectHandlerInterface, ProjectHandler\Handler\InterfaceHandler,
        ProjectHandler\Handler\InterfaceProject
{

    /**
     * 
     * @since 18-01-03
     * @edit 18-05-13
     * - Added use from UnitTest\HandlerProject
     */
    use ProjectHandler\Handler\Common;

    /**
     * 
     * @return void
     * 
     * @since 18-01-03
     * @edit 18-01-03
     * @edit 18-05-13
     * - Added method from UnitTest\HandlerProject
     */
    public function execUnitTest()
    {
        ob_start();
        ?>
        <table class="table table-bordered"> 
            <caption>Unit test on file public methods</caption>
            <tr>
                <th class='info'>Class</th>
                <th class='info'>Status</th>
                <th class='info'>#UT</th>
            </tr>
            <?php
            $this->unitTestStatus = true;
            foreach (static::projectClasses() as $classTest) {
                $classTest = new \GIndie\ProjectHandler\Handler\HandlerClass($classTest);
                $classTest->execUnitTest();
                switch (true)
                {
                    case \is_string($classTest->unitTestStatus):
                        $this->unitTestStatus = false;
                        echo "<tr class='warning'><td>{$classTest->formattedTitle()}</td><td>{$classTest->unitTestStatus}</td><td>{$classTest->unitTestCount}</td></tr>";
                        break;
                    case ($classTest->unitTestStatus === true):
                        $this->unitTestCount += $classTest->unitTestCount;
                        echo "<tr class='success'><td>{$classTest->formattedTitle()}</td><td>Success</td><td>{$classTest->unitTestCount}</td></tr>";
                        break;
                    default:
                        $this->unitTestStatus = false;
                        echo "<tr class='danger'><td>{$classTest->formattedTitle()}</td><td>{$classTest->unitTestLastError}</td><td>{$classTest->unitTestCount}</td></tr>";
                        break;
                }
            }
            ?>
            <tr>
                <th class=''></th>
                <th class='info' >Unit tests executed</th>
                <th class='info'><?= $this->unitTestCount; ?></th>
            </tr>
        </table>
        <?php
        $out = ob_get_contents();
        ob_end_clean();
        $this->unitTestResult = $out;
        return;
    }

    /**
     * 
     * @since 18-01-03
     * @return string
     * @edit 18-01-03
     * @edit 18-05-13
     * - Added method from UnitTest\HandlerProject
     */
    public function formattedTitle()
    {
        ob_start();
        ?>
        <sub><?= static::projectVendor() . static::projectNamespace(); ?></sub>
        <?= static::projectName(); ?>
        <?php
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

    /**
     * @return array
     * @since 18-05-13
     * @todo
     * - Implement traits and non-main classes.
     */
    public static function projectClasses()
    {
        return static::mainClasses();
    }

    /**
     * @return array
     * @since 18-02-23
     * 
     */
    public static function mainClasses()
    {
        return [];
    }

    /**
     * @return string
     * @since 18-02-23
     * @edit 18-02-24
     */
    public static function autoloaderFilename()
    {
        return "Autoloader" . static::projectName() . ".php";
    }

    /**
     * 
     * @return string
     * @since 18-02-24
     */
    public static function getNamespace()
    {
        $rntStr = "\\" . static::projectVendor();
        $rntStr .= static::projectNamespace() ? "\\" . static::projectNamespace() : "";
        $rntStr .= "\\" . static::projectName();
        return $rntStr;
    }

    /**
     * @return array
     * @since 18-03-27
     */
    public static function excludeFromPhar()
    {
        return [".git", ".gitignore", "nbproject"];
    }

}
