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
 * @version 0B.70
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
 * - Handle DEPRECATED and DOING versions
 * - Added getLOC()
 * @edit 18-09-25
 * - Fixed bugs in build
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
        return \GIndie\Common\PHP\Date::reducedDateFromTimestamp($this->splFileInfo->getMTime());
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
     * @since 18-09-18
     */
    private $contentArray;

    /**
     *
     * @var array 
     * @since 18-05-18
     */
    private $contentTokens;

    /**
     * 
     * @return int
     * @since 18-09-18
     */
    public function getLOC()
    {
        return \count($this->contentArray);
    }

    /**
     * @param string $fileId
     * @param \SplFileInfo $splFileInfo
     * @since 18-05-18
     * @edit 18-05-19
     * - Added param $fileId
     * - $currentVersion stores as "NDFND" when value = "UNDEFINED"
     * @edit 18-09-18
     * - $currentVersion stores as "DOING" when value contains = "DOING"
     * - $currentVersion stores as "DPRCT" when value = "DEPRECATED"
     * - Stores $this->contentArray
     * @edit 18-09-25
     * - Fixed version bug in filetype = 'NDF'
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
        $this->contentArray = \file($this->fullPath, \FILE_SKIP_EMPTY_LINES);
        $this->contentTokens = \token_get_all($this->contentRaw);
//        var_dump(token_name(382));
//        var_dump($this->contentTokens);
        //trigger_error("test", \E_USER_ERROR);
        $this->docComment = $this->setDocComments();
        //find last edit
        $this->lastEdit = \strtotime("00-05-05");
        $this->filetype = $this->setFileType();
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
                break;
            case "DEPRECATED":
                $this->currentVersion = "DPRCT";
                break;
        }
        switch ($this->filetype)
        {
            case "NDF":
                $this->currentVersion = "NDFND";
                break;
        }
        if (\strstr($this->currentVersion, "DOING") !== false) {
            $this->currentVersion = "DOING";
        }
        $this->lastEdit = \date("y-m-d", $this->lastEdit);
        //Other

        $this->setFileId($fileId);
    }

    /**
     * 
     * @return string
     * @since 18-05-17
     * @edit 18-09-25
     * - Graciously handle FILETYPE_UNDEFINED
     * @todo
     * - Single return statement
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
            case (\strcmp($this->splFileInfo->getExtension(), "log") == 0):
                $this->currentVersion = "NDFND";
                return static::FILETYPE_LOG;
                break;
            default:
                return static::FILETYPE_UNDEFINED;
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
     * @edit 18-09-18
     * - Graciously handle DOING
     * @edit 18-09-25
     * - Fixed version bug in DPRCT
     */
    public function getBuild()
    {
        $rntVal;
        switch ($this->currentVersion)
        {
            case "DOING":
            case "NDFND":
            case "DPRCT":
            case "DEPRECATED":
                $rntVal = null;
                break;
            default:
                $rntVal = \hexdec($this->currentVersion);
                break;
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
