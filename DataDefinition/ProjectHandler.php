<?php

namespace GIndie\ProjectHandler\DataDefinition;

/**
 * DVLP-GICommon - ProjectHandlerInterface
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\DataDefinition
 *
 * @since 18-02-23
 * @edit 18-02-23
 * - Added methods from UnitTest\GIndie\UnitTest\Handler\InterfaceProject
 * @edit 18-03-27
 * - Added excludeFromPhar();
 * @version 0A.00
 * @edit 18-05-13
 * - Moved class from external project GI-Common
 * @version 0A.F0
 * @edit 18-05-17
 * - Renamed interface from ProjectHandlerInterface to ProjectHandler
 * - Upgraded file structure and namespace for A.1
 * - Added versions(), execVersionHandler()
 * @version 0A.10
 * @edit 18-05-19
 * - Revised Project packages
 * @version 0A.50
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
     * @edit GI-CMMN.00.02
     */
    public static function autoloaderFilename();

    /**
     * @return array
     * @since 18-03-27
     */
    public static function excludeFromPhar();
}
