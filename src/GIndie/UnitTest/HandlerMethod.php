<?php
/**
 * UnitTest - HandlerMethod
 */

namespace GIndie\UnitTest;

/**
 * Description of HandlerMethod
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 18-01-03 Class created.
 * @edit UT.00.01
 * - Added code from GIndie\UnitTest\ClassTest\ReflectionMethod
 * - Updated traits
 * - Interfaces implemented.
 * @edit UT.00.02
 * - $unitTestCount implemented
 * - Implemented error on Unit Test not defined
 */
class HandlerMethod extends \ReflectionMethod implements Handler\InterfaceHandler, Handler\ReflectionInterface
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
     * 
     * @param type $class
     * @param type $name
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
     * @edit UT.00.02
     */
    public function execUnitTest()
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
            if (isset($this->docComments["unit_test"])) {
                foreach ($this->docComments["unit_test"] as $utKey => $utData) {
                    echo $this->handleTest($utKey, $utData);
                }
            } else {
                $this->unitTestStatus = false;
                $this->unitTestLastError = "Unit test not declared for method " . $this->name;
            }
            ?>
        </table>
        <?php
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

    /**
     * @since UT.00.01
     * return array
     */
    public function requiredTags()
    {
        return ["since", "version", "return"];
    }

    /**
     * 
     * @since UT.00.01
     * 
     * @param type $data
     * @return string
     * @edit UT.00.02
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
                $classTest = new HandlerClass($this->class);
                //\var_dump($parameters);
                //\var_dump(["attr1"=>"val1","attr2","attr3"=>null,null=>"attr4"]);
                $result = $classTest->newInstance($parameters);
            default:
                $class = $utData["factory"]["class"];
                $method = $utData["factory"]["method"];
                $testId = $utData["factory"]["testId"];
                $factory = new self($class, $method);
                $docComments = $factory->getDocComments();
                $factory = $factory->invokeArgs(null, $docComments["unit_test"][$testId]["parameters"]);
                $result = $this->invokeArgs($factory, $parameters) . "";
                break;
        }
        $this->unitTestCount++;
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
     * @since UT.00.01
     * 
     * @param array $parameters
     * @return string
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
