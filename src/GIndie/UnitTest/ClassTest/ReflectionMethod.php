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
 */
class ReflectionMethod extends \ReflectionMethod
{

    /**
     * 
     * @since UT.00.01
     * 
     * @param \ReflectionMethod $Method
     * @return string Description
     * 
     */
    public function validate()
    {
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

}
