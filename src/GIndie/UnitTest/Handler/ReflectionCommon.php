<?php

/**
 * UnitTest - ReflectionCommon
 */

namespace GIndie\UnitTest\Handler;

/**
 * Description of ReflectionCommon
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 18-01-03 Trait created.
 * @edit UT.00.01
 * - Moved in methods.
 */
trait ReflectionCommon
{

    /**
     * 
     * @since UT.00.01
     * @return array
     */
    public function getDocComments()
    {
        return $this->docComments;
    }

    /**
     * @since UT.00.01
     * @return string
     */
    public function formattedTitle()
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
     */
    protected $docComments;

}
