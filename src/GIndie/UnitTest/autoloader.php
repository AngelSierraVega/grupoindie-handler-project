<?php

/**
 * UnitTest - autoloader
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 * @version UT.00.00 2017-12-25 File created
 */

namespace GIndie\UnitTest;

/**
 * Autoloader function
 * 
 * @edit UT.00.012017-12-26 
 * - Copy from GICommon
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