<?php

namespace GIndie\ProjectHandler;

use GIndie\ScriptGenerator\HTML5;

/**
 * GI-ProjectHandler-DVLP - VersionHandler 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package ProjectHandler
 *
 * @since 18-05-17
 * @version 0A.35
 */
class VersionHandler implements DataDefinition\VersionHandler
{

    /**
     *
     * @var \GIndie\ProjectHandler\DataDefinition\ProjectHandler
     * @since 18-05-17
     */
    protected $projectHandler;

    /**
     *
     * @var \GIndie\ProjectHandler\FileHandler[] 
     * @since 18-05-17
     */
    private $fileHandler;

    /**
     *
     * @var int 
     * @since 18-05-18
     */
    private $currentBuild;

    /**
     * 
     * @param string $pathToSourceCode
     * @return boolean
     * @since 18-05-17
     */
    private function handleFiles($pathToSourceCode)
    {
        $exclude = $this->projectHandler->excludeFromPhar();
        $filter = function ($file, $key, $iterator) use ($exclude) {
            if (\in_array($file->getFilename(), $exclude)) {
                return false;
            }
            return true;
        };
        $innerIterator = new \RecursiveDirectoryIterator(
                $pathToSourceCode, \RecursiveDirectoryIterator::SKIP_DOTS
        );
        $iterator = new \RecursiveIteratorIterator(
                new \RecursiveCallbackFilterIterator($innerIterator, $filter)
        );
        $this->currentBuild = 0;
        foreach ($iterator as $key => $value) {
            $fileHandlerTemp = $this->getFileHandler($value);
            $this->currentBuild += \hexdec($fileHandlerTemp->getCurrentVersion());
            $this->fileHandler[$fileHandlerTemp->getFileId()] = $fileHandlerTemp;
        }
        $this->currentBuild = ($this->currentBuild / \count($this->fileHandler));
        //$this->currentBuild = \count($this->fileHandler);
        return true;
    }

    /**
     * 
     * @param \SplFileInfo $fileInfo
     * @return \GIndie\ProjectHandler\FileHandler
     * @since 18-05-17
     */
    private function getFileHandler(\SplFileInfo $fileInfo)
    {
        return new FileHandler($fileInfo);
    }

    /**
     * 
     * @param \GIndie\ProjectHandler\DataDefinition\ProjectHandler $projectHandler
     * @since 18-05-17
     */
    public function __construct(DataDefinition\ProjectHandler $projectHandler)
    {
        $this->projectHandler = $projectHandler;
        $this->handleFiles(\realpath($this->projectHandler->pathToSourceCode()));
    }

    /**
     * @since 18-05-17
     * @return array An array with package id's.
     */
    public function getPackages()
    {
        return ["ProjectHandler"];
    }

    /**
     * @since 18-05-17
     * @return array An associative array where key = 'file id' and value
     *               = 'package id'.
     */
    public function getFiles()
    {
        return "todo";
    }

    /**
     * @since 18-05-17
     * @return array An associative array where key = 'package id' and
     *               value = 'an html node displaying the results'.
     */
    public function getHtmlResults()
    {
        $rntArray = [];
        $versionsTable = new HTML5\Tables\Table();
        $rntArray["Versions"] = $versionsTable;
        $versionsTable->addHeader(["Threshold", "Code", "Description", "Status"]);
        foreach ($this->projectHandler->versions() as $tmpVersion) {
            $versionsTable->addRow([$tmpVersion["threshold"], $tmpVersion["code"], $tmpVersion["description"], "@todo"]);
        }
        foreach ($this->getPackages() as $packageId) {
            $rntArray[$packageId] = $this->getHtmlResult($packageId);
        }

        $preNode = HTML5\Format::preformatted("");
        $preNode->addContent("-------------------------------PACKAGE---------------------------------|\n");
        $preNode->addContent(" " . $this->projectHandler->getNamespace() . " v " . $this->getProjectVersion() . "\n");
        
        $preNode->addContent("--------------------------------FILE-----------------------------|--V--|\n");
        foreach ($this->fileHandler as $key => $value) {
            $txtRow = "[" . $value->getFiletype() . "] " . $value->getFileId() . "";
            $txtRow = \str_pad($txtRow, 65,"."); 
            $txtRow .= "|" . $value->getCurrentVersion() . "|\n";
            $preNode->addContent($txtRow);
        }
        $preNode->addContent("-----------------------------------------------------------------------|\n");
        $rntArray["TextVersion"] = $preNode;
        //return $rtnNode;

        return $rntArray;
    }

    /**
     * @since 18-05-17
     * @return type An html node displaying the result of the specified package.
     */
    public function getHtmlResult($packageId = null)
    {
        $rtnNode = new HTML5\Tables\Table();
        $rtnNode->addClass("table table-bordered table-condensed");
        $rtnNode->addHeader(HTML5\Tables::cellHeader($this->projectHandler->getNamespace() . " v " . $this->getProjectVersion())->setAttribute("colspan", "6"));
        $header = $rtnNode->getHeader();
        $header->addRow(["#", "File", "File type", "Current version", "Version (int)", "Last edit"]);
        //$rtnNode->addHeader(["#", "File", "File type", "Current version", "Version (int)", "Last edit"]);
        foreach ($this->fileHandler as $key => $value) {
            $rtnNode->addRow(["[@todo]", $value->getFileId(), $value->getFiletype(), $value->getCurrentVersion(), \hexdec($value->getCurrentVersion()) . " (" . \dechex(\hexdec($value->getCurrentVersion())) . ")", $value->getLastEdit()]);
        }
        return $rtnNode;
    }

    /**
     * @since 18-05-17
     */
    public function getProjectVersion()
    {
        return \dechex($this->currentBuild) . " (" . $this->currentBuild . ")";
        return "@doing";
    }

    /**
     * @since 18-05-17
     */
    public function getPackageVersion($packageId)
    {
        return "todo";
    }

    /**
     * @since 18-05-17
     */
    public function getFileVersion($fileId)
    {
        return "todo";
    }

}
