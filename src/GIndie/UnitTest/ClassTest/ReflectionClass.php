<?php
/**
 * UnitTest - ReflectionClass
 */

namespace GIndie\UnitTest\ClassTest;

/**
 * Description of ReflectionClass
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 17-12-25
 * @edit UT.00.01 17-12-28 
 * - Added code from UnitTest\ClassTest
 * @edit UT.00.02
 * - Functional class
 * @edit UT.00.03
 * @edit UT.00.04 17-12-29
 * - Implemented interterface and trait
 */
class ReflectionClass extends \ReflectionClass implements ReflectionInterface
{

    /**
     * @since UT.00.04
     */
    use \GIndie\UnitTest\ClassTest\ReflectionCommon;

    /**
     * 
     * @since UT.00.02
     * @param type $argument
     * @edit UT.00.03
     */
    public function __construct($argument)
    {
        parent::__construct($argument);
        $this->docComments = \GIndie\Common\Parser\DocComment::parseFromString($this->getDocComment());
        foreach ($this->getMethods() as $ReflectionMethod) {
            switch ($this->getFileName())
            {
                case $ReflectionMethod->getFileName():
                    $this->fileMethods[] = new ReflectionMethod($this->getName(), $ReflectionMethod->name);
                    break;
            }
        }
    }

    /**
     * @since UT.00.04
     * @return array
     */
    public function requiredTags()
    {
        return ["copyright", "package", "description", "author", "version"];
    }

    /**
     * @edit UT.00.04
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
     * @since UT.00.02
     * 
     * @return string Description
     * @edit UT.00.04
     */
    private function validateMethods()
    {
        $rtnStr = "";
        foreach ($this->fileMethods as $ReflectionMethod) {//ReflectionMethod::IS_PROTECTED
            $rtnStr .= $ReflectionMethod->validate();
        }
        return $rtnStr;
    }

    /**
     * @since UT.00.03
     * @var array
     */
    private $fileMethods = [];

}
