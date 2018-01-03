<?php
/**
 * UnitTest - HandlerClass
 */

namespace GIndie\UnitTest;

/**
 * Description of HandlerClass
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 18-01-03 Class created.
 * @edit UT.00.01
 * - Added code from GIndie\UnitTest\ClassTest\ReflectionClass
 * - Updated traits
 * - Interfaces implemented.
 * @edit UT.00.02
 * - $unitTestCount implemented
 */
class HandlerClass extends \ReflectionClass implements Handler\InterfaceHandler, Handler\ReflectionInterface
{

    /**
     * 
     * @since UT.00.01
     */
    use Handler\Common;
    use Handler\ReflectionCommon;

    /**
     * 
     * @since UT.00.01
     * @param type $argument
     * @todo verify deprecated code
     */
    public function __construct($argument)
    {
        parent::__construct($argument);
        $this->docComments = \GIndie\Common\Parser\DocComment::parseFromString($this->getDocComment());
        foreach ($this->getMethods() as $ReflectionMethod) {
            switch ($this->getFileName())
            {
                case $ReflectionMethod->getFileName():
                    switch (true)
                    {
                        case (\strcmp($ReflectionMethod->name, "__toString") == 0):
                        case $ReflectionMethod->isProtected():
                        case ($this->isAbstract() && $ReflectionMethod->isConstructor()):
                            break;
                        /**
                         * @todo verify deprecated code
                         * case $this->isAbstract():
                            if ($ReflectionMethod->isConstructor()) {
                                break;
                            }
                         */
                        
                        default:
                            $this->fileMethods[] = new HandlerMethod($this->getName(), $ReflectionMethod->name);
                            break;
                    }
                    break;
            }
        }
    }

    /**
     * 
     * @since UT.00.01
     * @return array
     */
    public function requiredTags()
    {
        return ["copyright", "package", "description", "author", "version"];
    }

    /**
     * 
     * @since UT.00.01
     * @return string
     */
    public function validate()
    {
        ob_start();
        ?>
        <table class="table table-bordered">
            <caption>validateProperties</caption>
            <tr>
                <th>getShortName</th>
                <th>isAbstract</th>
                <th>isInterface</th>
                <th>isTrait</th>
                <th>getFileName</th>
            </tr>
            <tr>
                <td><?= $this->getShortName(); ?></td>
                <td><?= $this->isAbstract() ? "Yes" : "No"; ?></td>
                <td><?= $this->isInterface() ? "Yes" : "No"; ?></td>
                <td><?= $this->isTrait() ? "Yes" : "No"; ?></td>
                <td><?= $this->getFileName(); ?></td>
            </tr>
        </table>
        <table class="table table-bordered">
            <caption>validateDocComments</caption>
            <tr>
                <?= $this->validateTag("description", "3"); ?>
                <?= $this->validateTag("link", "2"); ?>
            </tr>
            <tr>
                <?= $this->validateTag("copyright"); ?>
                <?= $this->validateTag("author"); ?>
                <?= $this->validateTag("package"); ?>
                <?= $this->validateTag("subpackage"); ?>
                <?= $this->validateTag("version"); ?>
            </tr>
            <?php
            foreach ($this->docComments["edit"] as $value) {
                echo "<tr><td colspan='5'><sup>@edit</sup> {$value}</td></tr>";
            }
            ?>
        </table>
        <?php
        $out = ob_get_contents();
        ob_end_clean();
        return $out . $this->validateMethods();
    }

    /**
     * Executes a method validation of the reflectionClass.
     * 
     * @since UT.00.01
     * 
     * @return string Description
     */
    public function execUnitTest()
    {
        $this->unitTestStatus = true;
        $rtnStr = "";
        foreach ($this->fileMethods as $ReflectionMethod) {//ReflectionMethod::IS_PROTECTED
            $rtnStr .= $ReflectionMethod->execUnitTest();
            if ($ReflectionMethod->unitTestStatus === false) {
                $this->unitTestStatus = false;
                $this->unitTestLastError = $ReflectionMethod->unitTestLastError;
            } else {
                $this->unitTestCount += $ReflectionMethod->unitTestCount;
            }
        }
        return $rtnStr;
    }

    /**
     * 
     * @since UT.00.01
     * @var array
     */
    private $fileMethods = [];

}
