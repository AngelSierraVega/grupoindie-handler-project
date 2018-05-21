<?php

namespace GIndie\ProjectHandler\Handler;

/**
 * Description of HandlerMethod
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\UnitTest
 *
 * @since 18-01-03
 * @edit 18-01-03
 * - Added code from GIndie\UnitTest\ClassTest\ReflectionMethod
 * - Updated traits
 * - Interfaces implemented.
 * - $unitTestCount implemented
 * - Implemented error on Unit Test not defined
 * @edit 18-02-??
 * - Updated handleTest()
 * @version 0A.00
 * @edit 18-05-13
 * - Upgraded file structure and namespace
 * - Upgraded uses and implementations
 * @version 0A.0F
 * @todo
 * - Upgrade/verify structure for A1
 */
class HandlerMethod extends \ReflectionMethod implements InterfaceHandler, ReflectionInterface
{

    /**
     * 
     * @since 18-01-03
     */
    use Common;
    use ReflectionCommon;

    /**
     * 
     * @since 18-01-03
     * 
     * @param type $class
     * @param type $name
     */
    public function __construct($class, $name)
    {
        parent::__construct($class, $name);
        $this->docComments = \GIndie\ProjectHandler\Parser\DocComment::parseFromString($this->getDocComment());
    }

    /**
     * 
     * @since 18-01-03
     * 
     * @param \ReflectionMethod $Method
     * @return string Description
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
                    //\var_dump($this->docComments["unit_test"]);
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
     * @since 18-01-03
     * return array
     */
    public function requiredTags()
    {
        return ["since", "version", "return"];
    }

    /**
     * 
     * @since 18-01-03
     * 
     * @param type $data
     * @return string
     * @edit 18-02-??
     * - Handle constructor and default methods
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
                $result = $classTest->newInstance($parameters);
                break;
            default:
                $class = $utData["factory"]["class"];
                $method = $utData["factory"]["method"];
                $testId = $utData["factory"]["testId"];
                switch ($method)
                {
                    case "__construct":
                        $classTest = new HandlerClass($this->class);
                        $docComments = $classTest->getDocComments();
                        $objectTest = $classTest->newInstance($docComments["unit_test"][$testId]["parameters"]);
                        $result = "@todo";
                        $result = $this->invokeArgs($objectTest, $parameters) . "";
                        break;
                    default:
                        $factory = new self($class, $method);
                        $docComments = $factory->getDocComments();
                        $factory = $factory->invokeArgs(null, $docComments["unit_test"][$testId]["parameters"]);
                        $result = $this->invokeArgs($factory, $parameters) . "";
                        break;
                }
                break;
        }
        $this->unitTestCount++;
        switch (true)
        {
            case (\strcmp($result, $expected) == 0):
                break;
            default:
                $this->unitTestLastError = $this->name .
                        "<br>Expected: <pre>" . \htmlspecialchars($expected) . "</pre>" .
                        "Result: <pre>" . \htmlspecialchars($result) . "</pre>";
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
     * @since 18-01-03
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
