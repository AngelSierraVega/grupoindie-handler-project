<?php

/**
 * GI-ProjectHandler-DVLP - FileHandler 
 *
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package ProjectHandler
 * 
 * @version 0A.35
 */

namespace GIndie\ProjectHandler\DataDefinition;

/**
 * 
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @since 18-05-18
 */
interface FileHandler extends FileHandlerConstants
{

    /**
     * 
     * @param \SplFileInfo $splFileInfo
     * @since 18-05-18
     */
    public function __construct(\SplFileInfo $splFileInfo);

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
