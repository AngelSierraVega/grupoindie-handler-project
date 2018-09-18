<?php

/**
 * GI-ProjectHandler-DVLP - FileHandler 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\FileHandler
 *
 * @since 18-05-16
 * @version 0B.30
 */

namespace GIndie\ProjectHandler;

/**
 *
 * @edit 18-05-18
 * @edit 18-05-19
 * - Functional constructor for defined private vars 
 * @edit 18-07-29
 * - Created getBuild()
 * @edit 18-09-18
 * - Added getRealEdit()
 */
class FileHandler implements DataDefinition\FileHandler
{

    /**
     * 
     * @return string
     * @since 18-09-18
     */
    public function getRealEdit()
    {
        return \GIndie\Common\PHP\Date::fullDateFromTimestamp($this->splFileInfo->getMTime());
    }

    /**
     *
     * @var \SplFileInfo 
     * @since 18-05-18
     */
    private $splFileInfo;

    /**
     *
     * @var string 
     * @since 18-05-18
     */
    private $contentRaw;

    /**
     *
     * @var array 
     * @since 18-05-18
     */
    private $contentTokens;

    /**
     * @param string $fileId
     * @param \SplFileInfo $splFileInfo
     * @since 18-05-18
     * @edit 18-05-19
     * - Added param $fileId
     * - $currentVersion stores as "NDFND" when value = "UNDEFINED"
     * @todo
     * - Explode or optimize code
     */
    public function __construct($fileId, \SplFileInfo $splFileInfo)
    {
        //$this->$splFileInfo->getMTime();
        //Define main vars
        $this->splFileInfo = $splFileInfo;
        $this->fullPath = $splFileInfo->getPathname();
        //Read file contents, tokenize them and parse doc comments
        $this->contentRaw = \file_get_contents($this->fullPath);
        $this->contentTokens = \token_get_all($this->contentRaw);
        $this->docComment = $this->setDocComments();
        //find last edit
        $this->lastEdit = \strtotime("00-05-05");
        foreach ($this->docComment as $tmpDocComment) {
            if (isset($tmpDocComment["edit"])) {
                foreach ($tmpDocComment["edit"] as $tmpEdit) {
                    $tmpDate = \strtotime(\explode(" - ", $tmpEdit)[0]);
                    if ($this->lastEdit < $tmpDate) {
                        $this->lastEdit = $tmpDate;
                    }
                }
            } elseif (isset($tmpDocComment["since"])) {
                if ($this->lastEdit < \strtotime($tmpDocComment["since"])) {
                    $this->lastEdit = \strtotime($tmpDocComment["since"]);
                }
            }
            if (isset($tmpDocComment["package"])) {
                $this->package = $tmpDocComment["package"];
            }
            if (isset($tmpDocComment["subpackage"])) {
                $this->subpackage = $tmpDocComment["subpackage"];
            }
            if (isset($tmpDocComment["version"])) {
                $this->currentVersion = $tmpDocComment["version"];
            }
        }
        switch ($this->currentVersion)
        {
            case "UNDEFINED":
                $this->currentVersion = "NDFND";
        }
        $this->lastEdit = \date("y-m-d", $this->lastEdit);
        //Other
        $this->filetype = $this->setFileType();
        $this->setFileId($fileId);
    }

    /**
     * 
     * @return string
     * @since 18-05-17
     */
    private function setFileType()
    {
        switch (true)
        {
            case (\array_search(\T_ABSTRACT, \array_column($this->contentTokens, 0)) !== false):
                return static::FILETYPE_ABSTRACT_CLASS;
                break;
            case (\array_search(\T_CLASS, \array_column($this->contentTokens, 0)) !== false):
                return static::FILETYPE_CLASS;
                break;
            case (\array_search(\T_INTERFACE, \array_column($this->contentTokens, 0)) !== false):
                return static::FILETYPE_INTERFACE;
                break;
            case (\array_search(\T_TRAIT, \array_column($this->contentTokens, 0)) !== false):
                return static::FILETYPE_TRAIT;
                break;
            case (\array_search(\T_OPEN_TAG, \array_column($this->contentTokens, 0)) !== false):
                return static::FILETYPE_SCRIPT;
                break;
            default:
                return "NDF";
                var_dump($this->contentTokens);
                return "@todo";
                break;
        }
    }

    /**
     *
     * @var string[] 
     * @since 18-05-18
     */
    private $docComment = [];

    /**
     * 
     * @return array
     * @since 18-05-18
     */
    private function setDocComments()
    {
        $rtnArray = [];
        $tmpArrayFilter = \array_filter($this->contentTokens, function($item) {
            switch (true)
            {
                case $item[0] == \T_DOC_COMMENT:
                    return true;
            }
        });
        foreach ($tmpArrayFilter as $key => $token) {
            $rtnArray[] = Parser\DocComment::parseFromString($token[1]);
        }
        return $rtnArray;
    }

    /**
     * @param string $fileId
     * @return boolean
     * @since 18-05-18
     * @edit 18-05-19
     * - Added param $fileId
     * @todo
     * - Remove file extention
     */
    private function setFileId($fileId)
    {
        $this->fileId = $fileId;
        return true;
    }

    /**
     * The id of the file.
     * @var string 
     * @since 18-05-18
     */
    private $fileId;

    /**
     * @return string The id of the file.
     * @since 18-05-18
     */
    public function getFileId()
    {
        return $this->fileId;
    }

    /**
     * The full path to the file.
     * @var string 
     * @since 18-05-18
     */
    private $fullPath;

    /**
     * @return string The full path to the file.
     * @since 18-05-18
     */
    public function getFullPath()
    {
        return $this->fullPath;
    }

    /**
     * The type of file.
     * @var string 
     * @since 18-05-18
     */
    private $filetype;

    /**
     * @return string The type of file.
     * @since 18-05-18
     */
    public function getFiletype()
    {
        return $this->filetype;
    }

    /**
     * The current version.
     * @var string 
     * @since 18-05-18
     */
    private $currentVersion;

    /**
     * @return string The current version.
     * @since 18-05-18
     */
    public function getCurrentVersion()
    {
        return $this->currentVersion;
    }

    /**
     * @return null|number The decimal representation of the current version
     * @since 18-07-29
     */
    public function getBuild()
    {
        $rntVal;
        switch ($this->currentVersion)
        {
            case "NDFND":
            case "DEPRECATED":
                $rntVal = null;
                break;
            default:
                $rntVal = \hexdec($this->currentVersion);
                break;
        }
        if (\strstr($this->currentVersion, "DOING") !== false) {
            $rntVal = null;
        }
        return $rntVal;
    }

    /**
     * The date of the last edit.
     * @var string 
     * @since 18-05-18
     */
    private $lastEdit;

    /**
     * @return string The date of the last edit.
     * @since 18-05-18
     */
    public function getLastEdit()
    {
        return $this->lastEdit;
    }

    /**
     * The package name.
     * @var string 
     * @since 18-05-18
     */
    private $package;

    /**
     * @return string The package name.
     * @since 18-05-18
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * The subpackage name.
     * @var string 
     * @since 18-05-18
     */
    private $subpackage;

    /**
     * @return string|null The subpackage name.
     * @since 18-05-18
     */
    public function getSubpackage()
    {
        return $this->subpackage;
    }

}
