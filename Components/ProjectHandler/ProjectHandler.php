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
 * @version A1.00
 */
class ProjectHandler extends \GIndie\ProjectHandler
{

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
