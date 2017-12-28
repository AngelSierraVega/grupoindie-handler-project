<?php
/**
 * UnitTest - ClassTest
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 */

namespace GIndie\UnitTest;

/**
 * Performs a Unit-Test on a given class.
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * 
 * @version GI.00.01 17-05-18 New class.
 * @version GI-CMMN.00.00 17-12-24 New project GICommon.
 * @edit GI-CMMN.00.01
 * - Sources from external project SG-DML
 * @edit GI-CMMN.00.02
 * - Moved class, renamed class, implements GIInterface
 * - Display error when not implementing a method defined in the class.
 * @edit GI-CMMN.00.03
 * - Created method's: validateDocCommentMethod(), handleMethod()
 * - Updated constructor. Using ReflectionClass to validate a class
 * 
 * @version UT.00.00 17-12-25 New project UnitTest
 * - Created dummie class
 * - Added functions from external project GICommon
 * - Removed abstract from original class.
 * - Removed implementation of interface.
 * @edit UT.00.01
 * - Updated run(), __construct()
 * - Created $reflectionClass
 * @edit UT.00.02
 * - Updated run(), validateDocCommentMethod()
 * @edit UT.00.03
 * - Deleted validateDocCommentMethod(), added code to validateMethod()
 * - Updated validateMethod()
 * - Created validateClass(), validateMethods()
 * - trait ToUpgrade used. Moved methods execExceptionCmp(), execStrCmp()
 * - trait ToDeprecate used.
 * @edit UT.00.04 17-12-28
 * - Added var $testTitle
 * - Added method: readClassProperties(), validateClassDocComments(), 
 * - Updated method: __construct()
 * @edit UT.00.05
 * - Added var: $docComments, $requiredClassTags
 * - Added method: getTableData()
 * - Updated method: validateClassDocComments()
 */
class ClassTest
{

    /**
     * @since UT.00.03
     */
    use \GIndie\UnitTest\ClassTest\ToUpgrade;
    use \GIndie\UnitTest\ClassTest\ToDeprecate;

    /**
     * 
     * @since UT.00.01
     * @var \ReflectionClass Stores the ReflectionClass object that handles the class.
     */
    private $reflectionClass;

    /**
     * Runs the user defined functions. Implementation of a singleton pattern for Test class.
     * 
     * @since GI.00.01
     * 
     * @return string
     * 
     * @edit UT.00.01
     * - Moved funcionality from constructor
     * - Removed visibility static
     * - Use $reflectionClass 
     * @edit UT.00.02
     * - Added output buffering insted of echo.
     * - Method returns string.
     * @edit UT.00.03
     * - Use validateClass(), validateMethods()
     */
    public function run()
    {
        $rtn = $this->validateClass();
        $rtn .= $this->validateMethods();
        return $rtn;
    }

    /**
     * Stores the ReflectionClass for handling.
     * 
     * @final
     * @since GI.00.01
     * 
     * @param string $classname The name of the class (including namespace) to be handled.
     * 
     * @edit UT.00.01
     * - Visivility changed to public. Added parameter $classname
     * - Moved functionality to run()
     * - Removed deprecated functionality
     * - Use $reflectionClass 
     * @edit UT.00.04
     * - Use var testTitle
     */
    final public function __construct($classname)
    {
        $this->reflectionClass = new \ReflectionClass($classname);
        $this->testTitle = $this->reflectionClass->getName();
    }

    /**
     * Executes a class validation
     * 
     * @since UT.00.03
     * 
     * @return string
     * @edit UT.00.04
     * - Use readClassProperties(), validateClassDocComments()
     */
    private function validateClass()
    {
        $out = $this->readClassProperties();
        $out .= $this->validateClassDocComments();
        return $out;
    }

    /**
     * readClassProperties
     * 
     * @since UT.00.04
     * @return string
     */
    private function readClassProperties()
    {
        ob_start();
        ?>
        <table class="table table-bordered">
            <caption>readClassProperties</caption>
            <tr>
                <th>getShortName</th>
                <th>isAbstract</th>
                <th>isInterface</th>
                <th>isTrait</th>
                <th>getFileName</th>
            </tr>
            <tr>
                <td><?= $this->reflectionClass->getShortName(); ?></td>
                <td><?= $this->reflectionClass->isAbstract() ? "Yes" : "No"; ?></td>
                <td><?= $this->reflectionClass->isInterface() ? "Yes" : "No"; ?></td>
                <td><?= $this->reflectionClass->isTrait() ? "Yes" : "No"; ?></td>
                <td><?= $this->reflectionClass->getFileName(); ?></td>
            </tr>
        </table>
        <?php
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

    /**
     * 
     * @since UT.00.05
     * @var array
     */
    private $requiredClassTags = ["copyright", "package", "description", "author", "version"];

    /**
     * 
     * @since UT.00.05
     * @var array|null 
     */
    private $docComments;

    /**
     * 
     * @since UT.00.05
     * 
     * @param string $tagname
     * @param string $colspan
     * 
     * @return string
     */
    private function getTableData($tagname, $colspan = "1")
    {
        if (\in_array($tagname, $this->requiredClassTags)) {
            if (isset($this->docComments[$tagname])) {
                $out = "<td colspan=\"{$colspan}\" class=\"success\">";
                $out .= "<sup>@{$tagname}</sup> ";
                $out .= $this->docComments[$tagname] . "</td>";
                return $out;
            } else {
                return "<td colspan=\"{$colspan}\" class=\"danger\"><sup>@{$tagname}</sup> Tag not setted.</td>";
            }
        } else {
            if (isset($this->docComments[$tagname])) {
                $out = "<td colspan=\"{$colspan}\" class=\"info\"><sup>@{$tagname}</sup> ";
                $out .= $this->docComments[$tagname] . "</td>";
                return $out;
            } else {
                return "<td colspan=\"{$colspan}\" ><sup>@{$tagname}</sup></td>";
            }
        }
    }

    /**
     * validateClassDocComments
     * 
     * @since UT.00.04
     * @return string
     * @edit UT.00.05
     * - Updated table
     * - Used var $docComments
     */
    private function validateClassDocComments()
    {
        $this->docComments = \GIndie\Common\Parser\DocComment::parseFromString($this->reflectionClass->getDocComment());
        ob_start();
        ?>
        <table class="table table-bordered">
            <caption>validateClassDocComments</caption>
            <tr>
                <?= $this->getTableData("description", "3"); ?>
                <?= $this->getTableData("link", "2"); ?>
            </tr>
            <tr>
                <?= $this->getTableData("copyright"); ?>
                <?= $this->getTableData("author"); ?>
                <?= $this->getTableData("package"); ?>
                <?= $this->getTableData("subpackage"); ?>
                <?= $this->getTableData("version"); ?>
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
        return $out;
    }

    /**
     * Executes a method validation of the reflectionClass.
     * 
     * @since UT.00.03
     * 
     * @return string Description
     */
    private function validateMethods()
    {
        $rtnStr = "";
        foreach ($this->reflectionClass->getMethods() as $ReflectionMethod) {//ReflectionMethod::IS_PROTECTED
            $rtnStr .= $this->validateMethod($ReflectionMethod);
        }
        return $rtnStr;
    }

    /**
     * 
     * @since GI-CMMN.00.03
     * 
     * @param \ReflectionMethod $Method
     * @return string Description
     * 
     * @edit UT.00.03
     * - Renamed from handleMethod
     * - Return string
     * - Added code from validateDocCommentMethod
     */
    private function validateMethod(\ReflectionMethod $Method)
    {
        $rtnStr = "";
        switch ($this->reflectionClass->getFileName())
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
     *
     * @since UT.00.04
     * @var string|null The title of the current test
     */
    public $testTitle;

}
