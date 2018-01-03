<?php

/**
 * UnitTest - ReflectionCommon
 */

namespace GIndie\UnitTest\ClassTest;

/**
 * Description of ReflectionCommon
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 * @version UT.00.00 17-12-28 Created trait
 * @edit UT.00.01 17-12-29
 * - Functional trait.
 * @edit UT.00.02 18-01-02
 * - Revised/added vars
 * - Added getDocComments()
 */
trait ReflectionCommon
{ 
    
    /**
     * 
     * @since UT.00.02
     * @return array
     */
    public function getDocComments(){
        return $this->docComments;
    }

    /**
     * @since UT.00.01
     * @return string
     */
    public function getTitle()
    {
        return $this->getName();
    }

    /**
     * validateTag
     * 
     * @since UT.00.01
     * 
     * @param string $tagname
     * @param string $colspan
     * 
     * @return string
     */
    public function validateTag($tagname, $colspan = "1")
    {
        if (\in_array($tagname, $this->requiredTags())) {
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
     * 
     * @since UT.00.01
     * @var array|null 
     * @edit UT.00.02
     */
    protected $docComments;
    
    /**
     * Stores the status of the unit test for the method.
     * 
     * @since UT.00.02
     * @var boolean|null 
     */
    public $unitTestStatus;
    
    /**
     * Stores the last error of the unit test for the method.
     * 
     * @since UT.00.02
     * @var string|null 
     */
    public $unitTestLastError;

}
