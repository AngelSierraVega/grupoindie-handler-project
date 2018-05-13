<?php

namespace GIndie\ProjectHandler;

/**
 * DVLP-GICommon - ProjectHandlerInterface
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package ProjectHandler
 *
 * @since 18-02-23
 * @edit 18-02-23
 * - Added methods from UnitTest\GIndie\UnitTest\Handler\InterfaceProject
 * @edit 18-03-27
 * - Added excludeFromPhar();
 * @version A0.00
 * @edit 18-05-13
 * - Moved class from external project GI-Common
 * @version A0.F0
 */
interface ProjectHandlerInterface
{

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
