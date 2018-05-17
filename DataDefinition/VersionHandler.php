<?php

namespace GIndie\ProjectHandler\DataDefinition;

/**
 * GI-ProjectHandler-DVLP - VersionHandler 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package ProjectHandler
 *
 * @since 18-05-17
 * @version 0A.40
 */
interface VersionHandler
{
    
    /**
     * @param \GIndie\ProjectHandler\DataDefinition\ProjectHandler $projectHandler
     * @since 18-05-17
     */
    public function __construct(ProjectHandler $projectHandler);

    /**
     * @since 18-05-17
     * @return array An array with package and subpackages id's.
     */
    public function getPackages();

    /**
     * @since 18-05-17
     * @return array An associative array where key = 'file id' and value
     *               = 'package id'.
     */
    public function getFiles();

    /**
     * @since 18-05-17
     * @return array An associative array where key = 'an html node displaying 
     *               the results' and value = 'package id'.
     */
    public function getHtmlResults();

    /**
     * @since 18-05-17
     * @return type An html node displaying the results.
     */
    public function getHtmlResult($packageId = null);

    /**
     * @since 18-05-17
     * @return type int|string 
     */
    public function getProjectVersion();

    /**
     * @since 18-05-17
     * @return type int|string 
     */
    public function getPackageVersion($packageId);

    /**
     * @since 18-05-17
     * @return type int|string 
     */
    public function getFileVersion($fileId);
}
