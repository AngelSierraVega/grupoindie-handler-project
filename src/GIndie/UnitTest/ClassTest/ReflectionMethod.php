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
 * @edit UT.00.05 18-01-02
 * - Removed deprecated funcionality
 * - Added @ut_factory funcionality
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
     * @edit UT.00.05
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
            $this->unitTestStatus = true;
            foreach ($this->docComments["unit_test"] as $utKey => $utData) {
                echo $this->handleTest($utKey, $utData);
            }
            ?>
        </table>
        <?php
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
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
     * @edit UT.00.05
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
                $class = $utData["factory"]["class"];
                $method = $utData["factory"]["method"];
                $testId = $utData["factory"]["testId"];
                $factory = new \GIndie\UnitTest\ClassTest\ReflectionMethod($class, $method);
                $docComments = $factory->getDocComments();
                $factory = $factory->invokeArgs(null, $docComments["unit_test"][$testId]["parameters"]);
                $result = $this->invokeArgs($factory, $parameters) . "";
                break;
        }

        switch (true)
        {
            case (\strcmp($result, $expected) == 0):
                break;
            default:
                $this->unitTestLastError = $this->name . "<br>Expected: {$expected}<br>Result: {$result}";
                $this->unitTestStatus = false;
                break;
        }
        ob_start();
        ?>
        <tr <?= $this->unitTestStatus ? "class=\"success\"" : "class=\"danger\""; ?>>
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
