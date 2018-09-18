<?php

/**
 * GI-ProjectHandler-DVLP - ProjectHandler 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\Main
 *
 * @since 18-02-23
 * @version 0B.00
 */

namespace GIndie\ProjectHandler\DataDefinition;

/**
 * 
 * @edit 18-02-23
 * - Added methods from UnitTest\GIndie\UnitTest\Handler\InterfaceProject
 * @edit 18-03-27
 * - Added excludeFromPhar();
 * @edit 18-05-13
 * - Moved class from external project GI-Common
 * @edit 18-05-17
 * - Renamed interface from ProjectHandlerInterface to ProjectHandler
 * - Upgraded file structure and namespace for A.1
 * - Added versions(), execVersionHandler()
 * @edit 18-05-19
 * - Revised Project packages
 * @edit 18-09-18
 * - Upgraded class's Docblock
 */
interface ProjectHandler
{

    /**
     * 
     * @return \GIndie\ProjectHandler\DataDefinition\VersionHandler
     * @since 18-05-17
     */
    public function execVersionHandler();

    /**
     * 
     * @return array An associative array with ...
     * @since 18-05-17
     */
    public static function versions();

    /**
     * @return array
     * @since 18-02-23
     */
    public static function mainClasses();

    /**
     * 
     * @since 18-02-23
     */
    public static function projectName();

    /**
     * 
     * @since 18-02-23
     */
    public static function projectNamespace();

    /**
     * 
     * @since 18-02-23
     */
    public static function projectVendor();

    /**
     * 
     * @since 18-02-23
     */
    public static function pathToSourceCode();

    /**
     * 
     * @since 18-02-23
     */
    public static function autoloaderFilename();

    /**
     * @return array
     * @since 18-03-27
     */
    public static function excludeFromPhar();
}
