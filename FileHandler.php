<?php

namespace GIndie\ProjectHandler;

/**
 * GI-ProjectHandler-DVLP - FileHandler 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package ProjectHandler
 *
 * @since 18-05-16
 * @edit 18-05-18
 * @version 0A.35
 */
class FileHandler implements DataDefinition\FileHandler
{

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
     * 
     * @param \SplFileInfo $fileInfo
     * @since 18-05-18
     */
    public function __construct(\SplFileInfo $splFileInfo)
    {
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
        }
        $this->lastEdit = \date("y-m-d", $this->lastEdit);
        //Other
        $this->currentVersion = $this->setCurrentVersion();
        $this->filetype = $this->setFileType();
        //todo
        $this->setFileId();
        $this->subpackage;
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
            case (\array_search(\T_ABSTRACT, \array_column($this->contentTokens, 0))
            !== false):
                return static::FILETYPE_ABSTRACT_CLASS;
                break;
            case (\array_search(\T_CLASS, \array_column($this->contentTokens, 0))
            !== false):
                return static::FILETYPE_CLASS;
                break;
            case (\array_search(\T_INTERFACE, \array_column($this->contentTokens, 0))
            !== false):
                return static::FILETYPE_INTERFACE;
                break;
            case (\array_search(\T_TRAIT, \array_column($this->contentTokens, 0))
            !== false):
                return static::FILETYPE_TRAIT;
                break;
            case (\array_search(\T_OPEN_TAG, \array_column($this->contentTokens, 0))
            !== false):
                return static::FILETYPE_SCRIPT;
                break;
            default:
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
     * 
     * @return string
     * @since 18-05-18
     */
    private function setCurrentVersion()
    {
        return isset($this->docComment[0]["version"]) ? $this->docComment[0]["version"] : "@unable_to_read";
    }

    /**
     * 
     * @return boolean
     * @since 18-05-18
     */
    private function setFileId()
    {
        $tmpStrPos = \strpos($this->getFullPath(), $this->getPackage());
        $this->fileId = \substr(
                $this->getFullPath(), \strpos($this->getFullPath(), $this->getPackage())
                + \strlen($this->getPackage()) +1
        );
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