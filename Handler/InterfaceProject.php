<?php

namespace GIndie\ProjectHandler\Handler;

/**
 * Description of InterfaceProject
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package ProjectHandler
 * 
 * @since 18-01-03
 * @edit 18-01-03
 * - Added code from UnitTest\HandlerProject.php
 * @version A0.00
 * @edit 18-05-13
 * - Upgraded file structure and namespace
 * @version A0.F0
 * @todo
 * - Upgrade/verify structure for A1
 */
interface InterfaceProject
{

    /**
     * 
     * @since 18-01-03
     */
    public static function projectClasses();

    /**
     * 
     * @since 18-01-03
     */
    public static function projectName();

    /**
     * 
     * @since 18-01-03
     */
    public static function projectNamespace();

    /**
     * 
     * @since 18-01-03
     */
    public static function projectVendor();
}
