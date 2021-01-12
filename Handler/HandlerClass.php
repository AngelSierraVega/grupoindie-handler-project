<?php

namespace GIndie\ProjectHandler\Handler;

/**
 * Description of HandlerClass
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\UnitTest
 *
 * @since 18-01-03
 * @edit 18-01-03
 * - Added code from GIndie\UnitTest\ClassTest\ReflectionClass
 * - Updated traits
 * - Interfaces implemented.
 * - $unitTestCount implemented
 * @version 0A.00
 * @edit 18-05-13
 * - Upgraded file structure and namespace
 * - Upgraded uses and implementations
 * @version 0A.0F
 * @todo
 * - Upgrade/verify structure for A1
 */
class HandlerClass extends \ReflectionClass implements InterfaceHandler, ReflectionInterface
{

    /**
     * 
     * @since 18-01-03
     * @edit 18-05-13
     */
    use Common;
    use ReflectionCommon;

    /**
     * 
     * @since 18-01-03
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
     * @since 18-01-03
     * @return array
     */
    public function requiredTags()
    {
        return ["copyright", "package", "description", "author", "version"];
    }

    /**
     * 
     * @since 18-01-03
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
     * @since 18-01-03
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
     * @since 18-01-03
     * @var array
     */
    private $fileMethods = [];

}
