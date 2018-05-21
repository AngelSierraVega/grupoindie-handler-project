<?php

namespace GIndie\ProjectHandler;

use GIndie\ScriptGenerator\HTML5;

/**
 * GI-ProjectHandler-DVLP - VersionHandler 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\VersionHandler
 *
 * @since 18-05-17
 * @version 0A.50
 * @edit 18-05-19
 * - Sepparated tables into MainPackage and Subpackage
 * - Added protected/private methods for displaying the results
 * @version 0A.60
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
    private $projectBuild;

    /**
     * 
     * @param string $pathToSourceCode
     * @return boolean
     * @since 18-05-17
     * @edit 18-05-19
     * - Handle storing of $fileHandler['package']['file_id']
     * - Abstracted code for RecursiveIteratorIterator into \GIndie\Common\PHP\Files
     * @todo
     * - Skip UNDEFINED
     * - Handle DOING ?
     */
    private function handleFiles($pathToSourceCode)
    {
        $iterator = \GIndie\Common\PHP\Files::getRecursiveIteratorIterator($pathToSourceCode, $this->projectHandler->excludeFromPhar());
        $this->projectBuild = 0;
        $tmpCount = 0;
        foreach ($iterator as $value) {
            $fileHandlerTemp = $this->getFileHandler($value);
            $this->fileHandler[$fileHandlerTemp->getPackage()][$fileHandlerTemp->getFileId()]
                    = $fileHandlerTemp;
            switch ($fileHandlerTemp->getCurrentVersion())
            {
                case "UNDEFINED":
                    break;
                default:
                    $tmpCount++;
                    $this->projectBuild += \hexdec($fileHandlerTemp->getCurrentVersion());
                    break;
            }
        }
        $this->projectBuild = ($this->projectBuild / $tmpCount);
        return true;
    }

    /**
     * 
     * @param \SplFileInfo $fileInfo
     * @return \GIndie\ProjectHandler\FileHandler
     * @since 18-05-17
     * @edit 18-05-19
     * - Upgraded funcionality for \GIndie\ProjectHandler\FileHandler
     */
    private function getFileHandler(\SplFileInfo $fileInfo)
    {
        $fileId = \substr(
                $fileInfo->getRealPath(), \strlen($this->projectHandler->pathToSourceCode())
        );
        return new FileHandler($fileId, $fileInfo);
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
        return \array_keys($this->fileHandler);
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
     * 
     * @return array An associative array where key = 'result identifier' and
     *               value = 'an html node displaying the results'.
     * @since 18-05-17
     * @edit 18-05-19
     * - Abstracted code into dspResultsTxt()
     * - Abstracted code into dspTableVersions()
     */
    public function getHtmlResults()
    {
        $rntArray = [];
        $rntArray["Versions"] = $this->dspTableVersions();
        foreach ($this->getPackages() as $packageId) {
            $rntArray[$packageId] = $this->dspTableSubpackage($packageId);
        }
        $rntArray["TextVersion"] = $this->dspResultsTxt();
        return $rntArray;
    }

    /**
     * 
     * @return \GIndie\ScriptGenerator\Dashboard\Tables\Table
     * @since 18-05-19
     * @todo
     * - Add caption
     */
    protected function dspTableVersions()
    {
        $versionsTable = new \GIndie\ScriptGenerator\Dashboard\Tables\Table();
        $versionsTable->addClass("table-bordered table-condensed");
        $versionsTable->addHeader(HTML5\Tables::cellHeader($this->projectHandler->getNamespace() . " v " . $this->getProjectVersion())->setAttribute("colspan", "6"));
        $header = $versionsTable->getHeader();
        $header->addRow(["Threshold", "Code", "Description", "Status"]);
        foreach ($this->projectHandler->versions() as $tmpVersion) {
            $versionsTable->addRow([$tmpVersion["threshold"], $tmpVersion["code"], $tmpVersion["description"], "@todo"]);
        }
        return $versionsTable;
    }

    /**
     * 
     * @return \GIndie\ScriptGenerator\Dashboard\Tables\Table
     * @since 18-05-19
     */
    protected function dspTableMainPackage()
    {
        return new \GIndie\ScriptGenerator\Dashboard\Tables\Table();
    }

    /**
     * 
     * @param string $subpackageId
     * @return \GIndie\ScriptGenerator\Dashboard\Tables\Table
     * @since 18-05-19
     */
    protected function dspTableSubpackage($subpackageId)
    {
        $rtnNode = new HTML5\Tables\Table();
        $rtnNode->addClass("table table-bordered table-condensed");
        $rtnNode->addHeader(HTML5\Tables::cellHeader($subpackageId . " |  v @getPackageVersion()")->setAttribute("colspan", "5"));
        $header = $rtnNode->getHeader();
        $header->addRow(["File type", "Current version", "File", "Build (#)", "Last edit"]);
        foreach ($this->fileHandler[$subpackageId] as $key => $value) {
            $rtnNode->addRow([$value->getFiletype(), $value->getCurrentVersion(), $value->getFileId(), \hexdec($value->getCurrentVersion()), $value->getLastEdit()]);
        }
        return $rtnNode;
        return new \GIndie\ScriptGenerator\Dashboard\Tables\Table();
    }

    /**
     * 
     * @return \GIndie\ScriptGenerator\HTML5\Format\Preformatted
     * @since 18-05-19
     */
    protected function dspResultsTxt()
    {
        $preNode = HTML5\Format::preformatted("");
        $preNode->addContent("-------------------------------PACKAGE---------------------------------|\n");
        $preNode->addContent(" " . $this->projectHandler->getNamespace() . " v " . $this->getProjectVersion() . "\n");
        $preNode->addContent("-------------------------------VERSIONS--------------------------------|\n");
        foreach ($this->projectHandler->versions() as $tmpVersion) {
            $preNode->addContent("[" . $tmpVersion["threshold"] . "] " . \str_pad($tmpVersion["code"], 13, ".") . "| " . $tmpVersion["description"] . "\n");
        }
        $preNode->addContent("--------------------------------FILE-----------------------------|--V--|\n");
        foreach ($this->fileHandler as $packageId => $fileId) {
            foreach ($fileId as $fileHandler) {
                $txtRow = "[" . $fileHandler->getFiletype() . "] " . $fileHandler->getFileId() . "";
                $txtRow = \str_pad($txtRow, 65, ".");
                $txtRow .= "|" . $fileHandler->getCurrentVersion() . "|\n";
                $preNode->addContent($txtRow);
            }
        }
        $preNode->addContent("-----------------------------------------------------------------------|\n");
        return $preNode;
    }

    /**
     * @since 18-05-17
     * @return type An html node displaying the result of the specified package.
     * @deprecated since 18-05-19
     * @todo
     * - Remove from interface and delete method
     */
    public function getHtmlResult($packageId = null)
    {
        return "@deprecating";
    }

    /**
     * @since 18-05-17
     */
    public function getProjectVersion()
    {
        return \dechex($this->projectBuild) . " (" . $this->projectBuild . ")";
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
