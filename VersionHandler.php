<?php

/**
 * GI-ProjectHandler-DVLP - VersionHandler 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\VersionHandler
 *
 * @since 18-05-17
 * @version 0B.00
 */

namespace GIndie\ProjectHandler;

use GIndie\ScriptGenerator\HTML5;

/**
 * 
 * @edit 18-05-19
 * - Sepparated tables into MainPackage and Subpackage
 * - Added protected/private methods for displaying the results
 * @edit 18-07-29
 * - Use getBuild()
 * @edit 18-09-18
 * - Added getFormattedPackageVersion()
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
     * - Skip UNDEFINED
     * @edit 18-05-21
     * - Skip DOING
     * @edit 18-07-29
     * - Use getBuild()
     */
    private function handleFiles($pathToSourceCode)
    {
        $iterator = \GIndie\Common\PHP\Files::getRecursiveIteratorIterator($pathToSourceCode, $this->projectHandler->excludeFromPhar());
        $this->projectBuild = 0;
        $tmpCount = 0;
        foreach ($iterator as $value) {
            $fileHandlerTemp = $this->getFileHandler($value);
            $this->fileHandler[$fileHandlerTemp->getPackage()][$fileHandlerTemp->getFileId()] = $fileHandlerTemp;
            $tmpBuild = $fileHandlerTemp->getBuild();
            if (\is_numeric($tmpBuild)) {
                $tmpCount++;
                $this->projectBuild += $tmpBuild;
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
            $advance = \hexdec($tmpVersion["threshold"]) . "-----" . $this->projectBuild;
            $advance = $this->projectBuild / \hexdec($tmpVersion["threshold"]);
            if ($advance > 1) {
                $advance = 1;
            }
            $advance = $advance * 100;
            $versionsTable->addRow([$tmpVersion["threshold"], $tmpVersion["code"], $tmpVersion["description"], $advance]);
        }
        return $versionsTable;
    }

    /**
     * 
     * @return \GIndie\ScriptGenerator\Dashboard\Tables\Table
     * @since 18-05-19
     * @deprecated since 18-08-04
     */
    protected function dspTableMainPackageDPR()
    {
        return new \GIndie\ScriptGenerator\Dashboard\Tables\Table();
    }

    /**
     * 
     * @param type $subpackageId
     * @return type
     * @since 18-09-18
     */
    protected function getFormattedPackageVersion($subpackageId)
    {
        return substr_replace(\str_pad(\strtoupper(\dechex($this->getPackageVersion($subpackageId))), 4, "0", \STR_PAD_LEFT), ".", 2, 0);
    }

    /**
     * 
     * @param string $subpackageId
     * @return \GIndie\ScriptGenerator\Dashboard\Tables\Table
     * @since 18-05-19
     * @edit 18-07-29
     * - Use getBuild()
     */
    protected function dspTableSubpackage($subpackageId)
    {
        $rtnNode = new HTML5\Tables\Table();
        $rtnNode->addClass("table table-bordered table-condensed");
        $rtnNode->addHeader(HTML5\Tables::cellHeader($subpackageId . " |  v " . $this->getFormattedPackageVersion($subpackageId) . " (" . $this->getPackageVersion($subpackageId) . ")")->setAttribute("colspan", "5"));
        $header = $rtnNode->getHeader();
        $header->addRow(["File type", "Current version", "File", "Last edit", "Real edit"]);
        foreach ($this->fileHandler[$subpackageId] as $key => $value) {
            $rtnNode->addRow([$value->getFiletype(), $value->getCurrentVersion() . " (" . $value->getBuild() . ")", $value->getFileId(), $value->getLastEdit(), $value->getRealEdit()]);
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
     * @edit 18-09-18
     */
    public function getProjectVersion()
    {
        return substr_replace(\str_pad(\strtoupper(\dechex($this->projectBuild)), 4, "0", \STR_PAD_LEFT), ".", 2, 0);
        //return \dechex($this->projectBuild) . " (" . $this->projectBuild . ")";
    }

    /**
     * @since 18-05-17
     * @edit 18-07-29
     * - Implemented funcionality
     */
    public function getPackageVersion($packageId)
    {
        $pkgBuild = 0;
        $tmpCount = 0;
        foreach ($this->fileHandler[$packageId] as $key => $value) {
            $tmpBuild = $value->getBuild();
            if (\is_numeric($tmpBuild)) {
                $tmpCount++;
                $pkgBuild += $tmpBuild;
            }
        }
        if ($tmpCount == 0) {
            return "NDFND";
        }
        return $pkgBuild / $tmpCount;
    }

    /**
     * @since 18-05-17
     */
    public function getFileVersion($fileId)
    {
        return "todo";
    }

}
