<?php
/**
 * UnitTest - ReflectionMethod
 */

namespace GIndie\UnitTest\ClassTest;

/**
 * Description of ReflectionMethod
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 * @package UnitTest
 * @version UT.00.00 17-12-28 Created class
 * @edit UT.00.01
 * - Functional class
 * @edit UT.00.02
 * @edit UT.00.03 18-01-01
 * - Implemented interterface and trait
 * @edit UT.00.04
 * - handle unit test funcionality
 */
class ReflectionMethod extends \ReflectionMethod implements ReflectionInterface
{

    /**
     * @since UT.00.03
     */
    use \GIndie\UnitTest\ClassTest\ReflectionCommon;

    /**
     * 
     * @param type $class
     * @param type $name
     * @since UT.00.03
     */
    public function __construct($class, $name)
    {
        parent::__construct($class, $name);
        $this->docComments = \GIndie\UnitTest\Parser\DocComment::parseFromString($this->getDocComment());
    }

    /**
     * 
     * @since UT.00.01
     * 
     * @param \ReflectionMethod $Method
     * @return string Description
     * @edit UT.00.04
     */
    public function validate()
    {
        ob_start();
        ?>
        <table class="table table-bordered">
            <caption>Validate Method Properties</caption>
            <tr>
                <th>getName</th>
                <th>isClosure</th>
                <th>isAbstract</th>
                <th>isConstructor</th>
                <th>isGenerator</th>
            </tr>
            <tr>
                <td><?= $this->getName(); ?></td>
                <td><?= $this->isClosure() ? "Yes" : "No"; ?></td>
                <td><?= $this->isAbstract() ? "Yes" : "No"; ?></td>
                <td><?= $this->isConstructor() ? "Yes" : "No"; ?></td>
                <td><?= $this->isGenerator() ? "Yes" : "No"; ?></td>
            </tr>
        </table>
        <table class="table table-bordered">
            <caption><?= $this->getName(); ?></caption>
            <tr>
        <?= $this->validateTag("description", "2"); ?>
                <?= $this->validateTag("link", "1"); ?>
            </tr>
            <tr>
        <?= $this->validateTag("return"); ?>
                <?= $this->validateTag("since"); ?>
                <?= $this->validateTag("version"); ?>
            </tr>
                <?php
                if (isset($this->docComments["edit"])) {
                    foreach ($this->docComments["edit"] as $value) {
                        echo "<tr><td colspan='5'><sup>@edit</sup> {$value}</td></tr>";
                    }
                }
                ?>
        </table>
        <table class="table table-bordered">
            <caption>Unit test for <?= $this->getName(); ?></caption>
            <tr>
                <th>Test</th>
                <th>Parameters</th>
                <th>Expected</th>
                <th>Result</th>
            </tr>
        <?php
        foreach ($this->docComments["unit_test"] as $utKey => $utData) {
            echo $this->handleTest($utKey, $utData);
        }
        ?>
        </table>
            <?php
            $out = ob_get_contents();
            ob_end_clean();
            return $out;

            $Method = $this;
            $rtnStr = "";
            switch ($this->getFileName())
            {
                case $Method->isConstructor():
                    break;
                case $Method->getFileName():
                    $comment = \GIndie\Common\Parser\DocComment::parseFromString($Method->getDocComment());
                    \ob_start();
                    ?>
                <span style="font-size: 1.1em; font-weight: bolder;"><?= $Method->name; ?></span><br>
                <?php
                if (isset($comment["return"])) {
                    ?>
                    <span style="font-size: 0.9em;">@return <?= $comment["return"]; ?></span><br>
                    <?php
                } else {
                    ?>
                    <span style="color:red;">@return tag must added to comment</span><br>
                    <?php
                }
                $out = \ob_get_contents();
                \ob_end_clean();
                return $out;
                break;
        }
        return $rtnStr;
    }

    /**
     * @since UT.00.03
     * return array
     */
    public function requiredTags()
    {
        return ["since", "version", "return"];
    }

    /**
     * 
     * @param type $data
     * @return string
     * @since UT.00.04
     */
    private function handleTest($utKey, $utData)
    {
        $parameters = isset($utData["parameters"]) ? $utData["parameters"] : [];
        $expected = $utData["expected"];
        switch (true)
        {
            case $this->isStatic():
                $result = $this->invokeArgs(null, $parameters) . "";
                break;
            case $this->isConstructor():
                $classTest = $this->class;
                $classTest = new \GIndie\UnitTest\ClassTest\ReflectionClass($classTest);
                $result = $classTest->newInstance($parameters);
            default:
                break;
        }
        ob_start();
        ?>
        <tr <?= \strcmp($result, $expected) == 0 ? "class=\"success\"" : "class=\"danger\""; ?>>
            <td><?= $utKey; ?></td>
            <td><?= $this->handleHTMLParameters($parameters); ?></td>
            <td><pre><?= \htmlspecialchars($expected); ?></pre></td>
            <td><pre><?= \htmlspecialchars($result); ?></pre></td>
        </tr>
        <?php
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

    /**
     * 
     * @param array $parameters
     * @return string
     * @since UT.00.04
     */
    private function handleHTMLParameters(array $parameters)
    {
        $rtnStr = "";
        foreach ($parameters as $parameter) {
            switch (true)
            {
                case \is_array($parameter):
                    $rtnStr .= \htmlspecialchars(\join(", ", $parameter)) . "<br>";
                    break;

                default:
                    $rtnStr .= \htmlspecialchars($parameter) . "<br>";
                    break;
            }
        }
        return $rtnStr;
    }

}
