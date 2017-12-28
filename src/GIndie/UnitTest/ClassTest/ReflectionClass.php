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
 */
class ReflectionClass extends \ReflectionClass
{

    /**
     * getTableData
     * 
     * @since UT.00.01
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
     * @since UT.00.01
     * 
     * @return string
     */
    private function validateDocComments()
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
     * readClassProperties
     * 
     * @since UT.00.01
     * @return string
     */
    public function validateProperties()
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
                <td><?= $this->getShortName(); ?></td>
                <td><?= $this->isAbstract() ? "Yes" : "No"; ?></td>
                <td><?= $this->isInterface() ? "Yes" : "No"; ?></td>
                <td><?= $this->isTrait() ? "Yes" : "No"; ?></td>
                <td><?= $this->getFileName(); ?></td>
            </tr>
        </table>
        <?php
        $out = ob_get_contents();
        ob_end_clean();
        return $out;
    }

    /**
     * 
     * @since UT.00.01
     * 
     * @param \ReflectionMethod $Method
     * @return string Description
     * 
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
     * @since UT.00.01
     * @var array|null 
     */
    private $docComments;

    /**
     * 
     * @since UT.00.01
     * @var array
     */
    private $requiredClassTags = ["copyright", "package", "description", "author", "version"];

    

    /**
     *
     * @since UT.00.01
     * @var string|null The title of the current test
     */
    public $testTitle;

}
