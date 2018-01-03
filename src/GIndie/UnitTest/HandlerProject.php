<?php
/**
 * UnitTest - HandlerProject
 */

namespace GIndie\UnitTest;

/**
 * Description of HandlerProject
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 18-01-03 Class created.
 * @edit UT.00.01
 * - Interface implemented with dummie methods.
 * - Use trait
 * - Defined abstract projectClasses(), projectNamespace(), projectVendor()
 * @edit UT.00.02
 * - Moved in code from Module\AbstractModule.php
 * - Moved out abstract functions to interface Handler\InterfaceProject
 * - Implemented $unitTestCount, $unitTestResult, execUnitTest(), formattedTitle(), Handler\InterfaceProject
 */
abstract class HandlerProject implements Handler\InterfaceHandler, Handler\InterfaceProject
{

    /**
     * 
     * @since UT.00.01
     */
    use Handler\Common;

    /**
     * 
     * @since UT.00.01
     * 
     * @return void
     * 
     * @edit UT.00.02
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
                $classTest = new \GIndie\UnitTest\HandlerClass($classTest);
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
     * @since UT.00.01
     * @return string
     * @edit UT.00.02
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

}
