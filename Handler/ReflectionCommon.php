<?php
namespace GIndie\ProjectHandler\Handler;

/**
 * Description of ReflectionCommon
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\UnitTest
 *
 * @since 18-01-03
 * @edit 18-01-03
 * - Moved in methods.
 * @version 0A.00
 * @edit 18-05-13
 * - Upgraded file structure and namespace
 * @version 0A.0F
 * @todo
 * - Upgrade/verify structure for A1
 */
trait ReflectionCommon
{

    /**
     * 
     * @since 18-01-03
     * @return array
     */
    public function getDocComments()
    {
        return $this->docComments;
    }

    /**
     * @since 18-01-03
     * @return string
     */
    public function formattedTitle()
    {
        return $this->getName();
    }

    /**
     * validateTag
     * 
     * @since 18-01-03
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
     * @since 18-01-03
     * @var array|null 
     */
    protected $docComments;

}
