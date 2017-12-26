<?php

/**
 * UnitTest - 01_Testing_a_class
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 17-12-26 File created
 */

require_once \realpath(__DIR__ . '/../../../GICommon/dist/GICommon.phar');
//require_once '../UnitTest.phar';
require_once '../../src/GIndie/UnitTest/autoloader.php';

$test = new \GIndie\UnitTest\ClassTest( \GIndie\UnitTest\ClassTest::class );
echo $test->run();