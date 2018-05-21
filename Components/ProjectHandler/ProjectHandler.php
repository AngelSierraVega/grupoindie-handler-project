<?php

namespace GIndie\ProjectHandler\Components\ProjectHandler;

/**
 * GI-ProjectHandler-DVLP - ProjectHandler 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\Components
 *
 * @since 18-05-14
 * @version 0A.10
 * @edit 18-05-17
 * - Defined project versions
 * @version 0A.15
 * @edit 18-05-19
 * - Updated versions()
 * @version 0A.60
 */
class ProjectHandler extends \GIndie\ProjectHandler\AbstractProjectHandler
{

    /**
     * 
     * @return string
     * @since 18-05-17
     * @edit 18-05-19
     * - Upgraded project versions 
     */
    public static function versions()
    {
        $rtnArray = parent::versions();
        //AlphaCero
        $rtnArray[\hexdec("0A.00")]["description"] = "Functional project: UnitTest";
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
        $rtnArray[\hexdec("0B.00")]["description"] = "Implemented VersionHandler and UnitTest";
        //BetaCero-F
        $rtnArray[\hexdec("0B.F0")]["code"] = "BetaCero-F";
        $rtnArray[\hexdec("0B.F0")]["description"] = "Implemented ScriptGenerator";
        $rtnArray[\hexdec("0B.F0")]["threshold"] = "0B.F0";
        //One
        $rtnArray[\hexdec("0C.00")]["description"] = "Version handling, phar administration and generation, and project unit test";
        \ksort($rtnArray);
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
