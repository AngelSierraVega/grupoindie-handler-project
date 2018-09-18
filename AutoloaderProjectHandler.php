<?php

/**
 * GI-ProjectHandler-DVLP - AutoloaderProjectHandler 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\ProjectDefinition
 * 
 * @version 0B.00
 *
 * @since 18-05-13
 * @edit 18-05-13
 * - Added code from GI-SG-DML
 * @edit 18-05-19
 * - Revised Project packages
 * @edit 18-09-18
 * - Removed autoload of deprecated class
 */

namespace GIndie\ProjectHandler;

/**
 * Autoloader function
 * @since 18-05-13
 */
\spl_autoload_register(function($className) {
    switch (\substr($className, 0, (\strlen(__NAMESPACE__) * 1)))
    {
        case __NAMESPACE__:
            $edited = \substr($className, \strlen(__NAMESPACE__) + \strrpos($className, __NAMESPACE__));
            $edited = \str_replace("\\", \DIRECTORY_SEPARATOR, __DIR__ . $edited) . ".php";
            if (\is_readable($edited)) {
                require_once($edited);
            }
    }
});


/**
 * Fixed requires
 * @since 18-05-13
 * @deprecated since 18-09-18
 * require_once(__DIR__ . "/Deprecated/ProjectHandler.php");
 */

