<?php
/**
 * UnitTest - AbstractModule
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * 
 */

namespace GIndie\UnitTest\Plugins\Platform\Module;

/**
 * Description of AbstractModule
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version UT.00.00 17-12-27 Class created.
 * @edit UT.00.01
 * - Added code from Platform/dist/examples
 * @edit UT.00.02 18-01-02
 * - Implemented project test
 */
abstract class AbstractModule extends \GIndie\Platform\Controller\Module
{

    /**
     * 
     * @since UT.00.01
     * @return array
     */
    public static function RequiredRoles()
    {
        return ["AS"];
    }

    /**
     * @since UT.00.01
     */
    public function config()
    {
        $this->configPlaceholder("i-i-i")->typeHTMLString("");
        $this->configPlaceholder("ii-i-i")->typeHTMLString("THIS MUST NOT APPEAR");
    }

    /**
     * 
     * @since UT.00.02
     * @return string
     */
    abstract protected function projectUnitTest();


    /**
     * 
     * @since UT.00.02
     * @return \GIndie\Platform\View\Widget
     */
    protected function widgetReload($id, $class, $selected)
    {
        switch ($id)
        {
            case "ii-i-i":
//                $this->classTest = [];
//                foreach ($this->projectUnitTest() as $classTest) {
//                    $this->classTest[] = new \GIndie\UnitTest\ClassTest($classTest);
//                }
                return new \GIndie\Platform\View\Widget("Unit test on public file methods", false, $this->unitTestPublicFileMethods());
            default:
                return parent::widgetReload($id, $class, $selected);
        }
    }

    /**
     * 
     * @since UT.00.02
     * @return string
     */
    private function unitTestPublicFileMethods()
    {
        $classTest0 = $this->projectUnitTest();
        $projectHandler = new $classTest0();
//        $this->projectUnitTest();
//        \var_dump(static::projectUnitTest());
        ob_start();
        ?>
        <table class="table table-bordered">
            <caption>unitTestPublicFileMethods</caption>
            <tr>
                <th class='info'>Class</th>
                <th class='info'>Status</th>
            </tr>
            <?php
            foreach ($projectHandler->projectClasses() as $classTest) {
                $classTest = new \GIndie\UnitTest\HandlerClass($classTest);
                $classTest->execUnitTest();
                switch (true)
                {
                    case \is_string($classTest->unitTestStatus):
                        echo "<tr class='warning'><td>{$classTest->formattedTitle()}</td><td>{$classTest->unitTestStatus}</td></tr>";
                        break;
                    case ($classTest->unitTestStatus === true):
                        echo "<tr class='success'><td>{$classTest->formattedTitle()}</td><td>Success</td></tr>";
                        break;
                    default:
                        echo "<tr class='danger'><td>{$classTest->formattedTitle()}</td><td>{$classTest->unitTestLastError}</td></tr>";
                        break;
                }
            }
            ?>
        </table>
        <?php
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

}
