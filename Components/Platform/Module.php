<?php

/**
 * GI-ProjectHandler-DVLP - Module 
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\Main
 *
 * @since 18-02-23
 * @version 0B.00
 */

namespace GIndie\ProjectHandler\Components\Platform;

use GIndie\Platform\View\Input;

/**
 * 
 * @edit 18-02-23
 * - Abstract class
 * - Created RequiredRoles(), config(), widgetReload(), projectHandler(), run()
 * @edit 18-02-24
 * - Updated run(), widgetReload(), 
 * - Created $projectHandler, displayProjectInformation(), pharCreationRequest(), pharCreationAction()
 * - Created pathToDistFolder(), pharFilename()
 * @edit 18-05-13
 * - Updated widgetReload()
 * @edit 18-05-17
 * - Created wdgtVersion()
 * @edit 18-06-26
 * - Copied class from GIndie\FrameworkInstance\ProjectHandler
 * @edit 18-09-18
 * - Upgraded class Docblock
 * @todo
 * - Display To do list in VersionHandler widget
 */
abstract class Module extends \GIndie\Platform\Controller\Module
{

    /**
     *
     * @var \GIndie\ProjectHandler 
     * @since 18-02-24
     */
    protected $projectHandler;

    /**
     * 
     * @return type
     * @since 18-02-24
     */
    private function displayProjectInformation()
    {
        $rntContent = new \GIndie\ScriptGenerator\Bootstrap3\Tables\Table();
        $row = new \GIndie\ScriptGenerator\Bootstrap3\Tables\Row();
        $row->addContent("pathToSourceCode");
        $row->addContent($this->projectHandler->pathToSourceCode());
        $rntContent->addRow($row);
        return $rntContent;
    }

    /**
     * 
     * @return string
     * 
     * @since 18-02-23
     */
    public static function projectHandler()
    {
        throw new \Exception("test");
    }

    /**
     * 
     * @return array
     * 
     * @since 18-02-23
     */
    public static function RequiredRoles()
    {
        return ["AS"];
    }

    /**
     * 
     * @since 18-02-23
     * @edit 18-05-13
     * - Added UnitTest widget
     * @edit 18-06-24
     * - Use placeholder()
     */
    public function config()
    {
        $this->placeholder("i-i-i")->typeHTMLString("[ProjectHandler]");
        $this->placeholder("ii-i-i")->typeHTMLString("[VersionHandler]");
        $this->placeholder("iii-i-i")->typeHTMLString("[UnitTest]");
    }

    /**
     * @since 18-05-16
     * @return \GIndie\Platform\View\Widget
     * @edit 18-05-17
     * - Use $this->projectHandler->execVersionHandler()
     */
    protected function wdgtVersion()
    {
        $versionHandler = $this->projectHandler->execVersionHandler();
        $widget = new \GIndie\Platform\View\Widget("Project version", false,
                                                   \array_values($versionHandler->getHtmlResults()),
                                                                 false, true);
        $widget->setContext("info");
        return $widget;
    }

    /**
     * 
     * @return \GIndie\Platform\View\Widget
     * 
     * @since 18-02-23
     * @edit 18-02-24
     * - Define $projectHandler, displayProjectInformation()
     * @edit 18-05-13
     * - Added code from UnitTest
     * @edit 18-05-16
     * - Updated UnitTest widget
     * - Use wdgtVersion()
     */
    protected function widgetReload($id, $class, $selected)
    {
        switch ($id)
        {
            case "i-i-i":
                $projectHandler = static::projectHandler();
                $this->projectHandler = new $projectHandler();
                $widget = new \GIndie\Platform\View\Widget("Project information",
                                                           false,
                                                           $this->displayProjectInformation(),
                                                           false, true);
                $button = \GIndie\Platform\View\Widget\Buttons::Custom("success",
                                                                       "Create phar",
                                                                       "REQUEST-PHAR",
                                                                       null,
                                                                       true);
                $widget->addButtonHeading($button);
                $widget->setContext("primary");
                break;
            case "ii-i-i":
                $widget = static::wdgtVersion();
                break;
            case "iii-i-i":
                $this->projectHandler->execUnitTest();
                $widget = new \GIndie\Platform\View\Widget("Project Unit Test",
                                                           false,
                                                           $this->projectHandler->unitTestResult);
                if ($this->projectHandler->unitTestStatus === true) {
                    $widget->setContext("success");
                } else {
                    $widget->setContext("warning");
                }
                break;
            default:
                $widget = parent::widgetReload($id, $class, $selected);
                break;
        }
        return $widget;
    }

    /**
     * 
     * @return string
     * @since 18-02-24
     */
    protected function pathToDistFolder()
    {
        return "C:\\Users\\angel_000\\Dropbox\\srcs\\dstr";
    }

    /**
     * @since 18-02-24
     * @return string
     */
    protected function pharFilename()
    {
        return "\\" . $this->projectHandler->projectName() . ".phar";
    }

    /**
     * 
     * @return type
     * @since 18-02-24
     */
    protected function pharCreationRequest()
    {
        $form = new \GIndie\Platform\View\Form();
        $form->setAttribute("gip-action", "CREATE-PHAR");
        $form->setAttribute("target", "#gip-modal .modal-content");

        $inputDistPath = Input::Text("dist-folder", $this->pathToDistFolder(),
                                     true, false,
                                     "ALT C:\\Users\\angel_000\\Dropbox\\srcs\\prdc\\SistemaIntegralIngresos");
        $form->addContent(Input::FomGroupClean("Distribution folder",
                                               "dist-folder", $inputDistPath));

        $namespace = $this->projectHandler->getNamespace();
        $namespace = \str_replace("\\", DIRECTORY_SEPARATOR, $namespace);
        $inputLocalPath = Input::Text("local-path", $namespace, true, false,
                                      "ALT \\private\\libs  ..\\ScriptGenerator  ..\\ScriptGeneratorNew");
        $form->addContent(Input::FomGroupClean("Local path", "local-path",
                                               $inputLocalPath));


        $inputFilename = Input::Text("filename", $this->pharFilename(), true,
                                     false);
        $form->addContent(Input::FomGroupClean("Filename", "filename",
                                               $inputFilename));

        $modal = \GIndie\Platform\View\Modal\Content::primary("Create phar file?",
                                                              $form);
        $btn = new \GIndie\Generator\DML\HTML5\Bootstrap3\Component\Button("Create phar",
                                                                           "submit");
        $btn->setForm($form->getId())->setValue("Submit");
        $btn->setContext("success");
        $modal->addFooterButton($btn);
        return $modal;
    }

    /**
     * 
     * @return type
     * @since 18-02-24
     * @edit 18-03-18
     * - Use View\Modal
     * @edit 18-03-27 Updated phar creation
     * - Use custom RecursiveDirectoryIterator with $projectHandler::excludeFromPhar()
     * - UTF-8 encoding
     * @edit 18-03-28
     * - Removed UTF-8 encoding
     */
    protected function pharCreationAction()
    {
        $pathToPhar = $_POST["dist-folder"] . $_POST["local-path"] . $_POST["filename"];
        $srcRoot = $this->projectHandler->pathToSourceCode();
        try {
            if (!\file_exists($srcRoot . $this->projectHandler->autoloaderFilename())) {
                throw new \Exception("Unable to read " . $srcRoot . $this->projectHandler->autoloaderFilename());
            } else {
                if (\GIndie\Common\PHP\Directories::createFolderStructure($_POST["dist-folder"],
                                                                          $_POST["local-path"])) {
                    $srcRoot = \realpath($srcRoot);
                    $exclude = $this->projectHandler->excludeFromPhar();
                    $filter = function ($file, $key, $iterator) use ($exclude) {
                        if (\in_array($file->getFilename(), $exclude)) {
                            return false;
                        }
                        return true;
                    };
                    $innerIterator = new \RecursiveDirectoryIterator(
                            $srcRoot, \RecursiveDirectoryIterator::SKIP_DOTS
                    );
                    $iterator = new \RecursiveIteratorIterator(
                            new \RecursiveCallbackFilterIterator($innerIterator,
                                                                 $filter)
                    );
//                    $iterator->rewind();
//                    $strTmp = "";
//                    while ($iterator->valid()) {
//                        switch (true)
//                        {
//                            default:
//                                $strTmp .= '<p>SubPathName: ' . $iterator->getSubPathName() . "</p>";
//                                $strTmp .= '<p>SubPath:     ' . $iterator->getSubPath() . "</p>";
//                                $strTmp .= '<p>Key:         ' . $iterator->key() . "</p>";
//                                $strTmp .= "<p>----------------------------------------</p>";
//                                break;
//                        }
//                        $iterator->next();
//                    }
//                    return \GIndie\Platform\View\Modal\Content::warning("todo", $strTmp);
                    if (\file_exists($pathToPhar)) {
                        \unlink($pathToPhar);
                    }
                    $phar = new \Phar($pathToPhar, 0,
                                      \substr($_POST["filename"], 1));
                    $phar->buildFromIterator($iterator, $srcRoot);
                    $phar->setStub($phar->createDefaultStub($this->projectHandler->autoloaderFilename()));
                    $phar->compressFiles(\Phar::BZ2);
                    /**
                     * @todo UFT-8 encoding
                     * $tmpContent = \file_get_contents($pathToPhar);
                     * $data = \mb_convert_encoding($tmpContent, 'UTF-8', 'auto');
                     * \file_put_contents($pathToPhar, $data);
                     */
                    if (\file_exists($pathToPhar)) {
                        $modal = \GIndie\Platform\View\Modal\Content::succcess("Phar created",
                                                                               $pathToPhar);
                    } else {
                        throw new \Exception($pathToPhar);
                    }
                } else {
                    throw new \Exception($pathToPhar);
                }
            }
        } catch (\Exception $exc) {
            $modal = \GIndie\Platform\View\Modal\Content::danger("Phar NOT created",
                                                                 $exc->getMessage());
        }
        return $modal;
    }

    /**
     * 
     * 
     * @since 18-02-23
     * @edit 18-02-24
     * - Function has single return
     * - Use pharCreationAction(), pharCreationRequest()
     */
    public function run($action, $id, $class, $selected)
    {
        $rtnAction = null;
        switch ($action)
        {
            case "REQUEST-PHAR":
                $rtnAction = $this->pharCreationRequest();
                break;
            case "CREATE-PHAR":
                $rtnAction = $this->pharCreationAction();
                break;
            default:
                $rtnAction = parent::run($action, $id, $class, $selected);
                break;
        }
        return $rtnAction;
    }

}
