<?php

/**
 * GI-ProjectHandler-DVLP - ProjectHandler 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\ProjectDefinition
 *
 * @since 18-02-23
 * @version 0B.00
 */

namespace GIndie\ProjectHandler\Components\ProjectHandler;

/**
 * 
 * @since 18-05-14
 * @edit 18-05-17
 * - Defined project versions
 * @edit 18-05-19
 * - Updated versions()
 * @edit 18-09-18
 * - Upgraded class Docblock
 */
class ProjectHandler extends \GIndie\ProjectHandler\AbstractProjectHandler
{

    /**
     * 
     * @return string
     * @since 18-05-17
     * @edit 18-05-19
     * - Upgraded project versions 
     * @edit 18-09-18
     * - Upgraded project versions 
     */
    public static function versions()
    {
        $rtnArray = [];
        //AlphaCero
        $rtnArray[\hexdec("0A.00")]["code"] = "AlphaCero";
        $rtnArray[\hexdec("0A.00")]["description"] = "Functional project: UnitTest";
        $rtnArray[\hexdec("0A.00")]["threshold"] = "0A.00";
        //AlphaCeroFinal
        $rtnArray[\hexdec("0A.0F")]["description"] = "Final adaptation for UnitTest into ProjectHandler";
        $rtnArray[\hexdec("0A.0F")]["code"] = "AlphaCeroFinal";
        $rtnArray[\hexdec("0A.0F")]["threshold"] = "0A.0F";
        //AlphaOne
        $rtnArray[\hexdec("0A.10")]["description"] = "Functional restructured project as ProjectHandler";
        $rtnArray[\hexdec("0A.10")]["code"] = "AlphaOne";
        $rtnArray[\hexdec("0A.10")]["threshold"] = "0A.10";
        //AlphaFive
        $rtnArray[\hexdec("0A.50")]["code"] = "AlphaFive";
        $rtnArray[\hexdec("0A.50")]["description"] = "Functional subpackage VersionHandler";
        $rtnArray[\hexdec("0A.50")]["threshold"] = "0A.50";
        //AlphaSix
        $rtnArray[\hexdec("0A.60")]["code"] = "AlphaSix";
        $rtnArray[\hexdec("0A.60")]["description"] = "VersionHandler: Functional packages";
        $rtnArray[\hexdec("0A.60")]["threshold"] = "0A.60";
        //AlphaAlpha
        $rtnArray[\hexdec("0A.A0")]["code"] = "AlphaAlpha";
        $rtnArray[\hexdec("0A.A0")]["description"] = "Functional subpackage UnitTest";
        $rtnArray[\hexdec("0A.A0")]["threshold"] = "0A.A0";
        //BetaCero
        $rtnArray[\hexdec("0B.00")]["code"] = "BetaCero";
        $rtnArray[\hexdec("0B.00")]["description"] = "Fully functional implementation of ProjectHandler, FileHandler, VersionHandler and UnitTest";
        $rtnArray[\hexdec("0B.00")]["threshold"] = "0B.00";
        //BetaOne
        $rtnArray[\hexdec("0D.00")]["code"] = "BetaD";
        $rtnArray[\hexdec("0D.00")]["description"] = "Functional GitHandler";
        $rtnArray[\hexdec("0D.00")]["threshold"] = "0D.00";
        //BetaFinal
        $rtnArray[\hexdec("0F.00")]["code"] = "BetaFinal";
        $rtnArray[\hexdec("0F.00")]["description"] = "Revised project to use ScriptGenerator";
        $rtnArray[\hexdec("0F.00")]["threshold"] = "0F.00";
        //One
        $rtnArray[\hexdec("10.00")]["code"] = "One";
        $rtnArray[\hexdec("10.00")]["description"] = "Version handling, phar administration and generation, and project unit test";
        $rtnArray[\hexdec("10.00")]["threshold"] = "10.00";
        //\ksort($rtnArray);
        return $rtnArray;
    }

    /**
     * 
     * @return string
     * @since 18-05-14
     */
    public static function pathToSourceCode()
    {
        return \GIndie\Common\PHP\Directories::getDirectoryFromFile(__FILE__, 2) . \DIRECTORY_SEPARATOR;
    }

    /**
     * 
     * @return string
     * @since 18-05-14
     */
    public static function projectName()
    {
        return "ProjectHandler";
    }

    /**
     * 
     * @return null
     * @since 18-05-14
     */
    public static function projectNamespace()
    {
        return null;
    }

    /**
     * 
     * @return string
     * @since 18-05-14
     */
    public static function projectVendor()
    {
        return "GIndie";
    }

}
