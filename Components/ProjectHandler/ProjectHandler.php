<?php

namespace GIndie\ProjectHandler\Components\ProjectHandler;

/**
 * GI-ProjectHandler-DVLP - ProjectHandler 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package ProjectHandler
 *
 * @since 18-05-14
 * @version 0A.10
 * @edit 18-05-17
 * - 
 * @version 0A.15
 */
class ProjectHandler extends \GIndie\ProjectHandler\AbstractProjectHandler
{

    /**
     * 
     * @return string
     * @since 18-05-17
     */
    public static function versions()
    {
        $rtnArray = parent::versions();
        //AlphaCero
        $rtnArray[\hexdec("0A.00")]["description"] = "Functional UnitTest";
        //AlphaCeroFinal
        $rtnArray[\hexdec("0A.0F")]["description"] = "Final adaptation for UnitTest into ProjectHandler";
        $rtnArray[\hexdec("0A.0F")]["code"] = "AlphaCeroFinal";
        $rtnArray[\hexdec("0A.0F")]["threshold"] = "0A.0F";
        //AlphaOne
        $rtnArray[\hexdec("0A.10")]["description"] = "Functional ProjectHandler";
        $rtnArray[\hexdec("0A.10")]["code"] = "AlphaOne";
        $rtnArray[\hexdec("0A.10")]["threshold"] = "0A.10";
        //AlphaOne-A
        $rtnArray[\hexdec("0A.50")]["code"] = "AlphaOne-A";
        $rtnArray[\hexdec("0A.50")]["description"] = "Functional subpackage VersionHandler";
        $rtnArray[\hexdec("0A.50")]["threshold"] = "0A.50";
        //AlphaOne-B
        $rtnArray[\hexdec("0A.A0")]["code"] = "AlphaOne-B";
        $rtnArray[\hexdec("0A.A0")]["description"] = "Functional subpackage UnitTest";
        $rtnArray[\hexdec("0A.A0")]["threshold"] = "0A.A0";
        //BetaCero
        $rtnArray[\hexdec("0B.00")]["code"] = "BetaCero";
        $rtnArray[\hexdec("0B.00")]["description"] = "Implemented VersionHandler and UnitTest";
        $rtnArray[\hexdec("0B.00")]["threshold"] = "0B.00";
        //BetaCero-F
        $rtnArray[\hexdec("0B.F0")]["code"] = "BetaCero-F";
        $rtnArray[\hexdec("0B.F0")]["description"] = "Implemented ScriptGenerator";
        $rtnArray[\hexdec("0B.F0")]["threshold"] = "0B.F0";
        //One
        $rtnArray[\hexdec("10.00")]["code"] = "One";
        $rtnArray[\hexdec("10.00")]["description"] = "Version handling, phar administration and generation, and project unit test";
        $rtnArray[\hexdec("10.00")]["threshold"] = "10.00";
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
