<?php

/**
 * UnitTest - phar
 *
 * @copyright (C) 2017 Angel Sierra Vega. Grupo INDIE.
 *
 * @package UnitTest
 *
 * @version UT.00.00 2017-12-25 File created
 */

/**
 * Crea un archivo phar
 * @edit UT.00.01
 * - Copy from GICommon
 */
$srcRoot = __DIR__ . "/src/GIndie/UnitTest";
$buildRoot = __DIR__ . "/dist";
$phar = new Phar($buildRoot . '/UnitTest.phar', 0, 'UnitTest.phar');
$Directory = new RecursiveDirectoryIterator($srcRoot, FilesystemIterator::SKIP_DOTS);
$Iterator = new RecursiveIteratorIterator($Directory);
$phar->buildFromIterator($Iterator, $srcRoot);
$phar->setStub($phar->createDefaultStub('autoloader.php'));
echo "Archivo phar (/dist/UnitTest.phar) creado con éxito";