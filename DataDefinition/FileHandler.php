<?php

/**
 * GI-ProjectHandler-DVLP - FileHandler 
 *
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 *
 * @package GIndie\ProjectHandler\FileHandler
 * @version 0B.00
 */

namespace GIndie\ProjectHandler\DataDefinition;

/**
 * 
 * 
 * @since 18-05-18
 * @edit 18-05-19
 * - Updated __construct()
 * @edit 18-09-18
 * - Upgraded class's Docblock
 * 
 */
interface FileHandler extends FileHandlerConstants
{

    /**
     * @param string $fileId
     * @param \SplFileInfo $splFileInfo
     * @since 18-05-18
     * @edit 18-05-19
     * - Added param $fileId
     */
    public function __construct($fileId, \SplFileInfo $splFileInfo);

    /**
     * @return string The id of the file.
     * @since 18-05-18
     */
    public function getFileId();

    /**
     * @return string The full path to the file.
     * @since 18-05-18
     */
    public function getFullPath();

    /**
     * @return string The type of file.
     * @since 18-05-18
     */
    public function getFiletype();

    /**
     * @return string The current version.
     * @since 18-05-18
     */
    public function getCurrentVersion();

    /**
     * @return string The last edit.
     * @since 18-05-18
     */
    public function getLastEdit();

    /**
     * @return string The package name.
     * @since 18-05-18
     */
    public function getPackage();

    /**
     * @return array The subpackage name.
     * @since 18-05-18
     */
    public function getSubpackage();
}
