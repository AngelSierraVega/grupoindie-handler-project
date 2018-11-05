<?php

namespace GIndie\ProjectHandler\Parser;

/**
 * Description of DocComment
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\ParserDocComment
 * 
 * @since 18-01-01
 * @edit 18-01-01
 * - Extend from \GIndie\Common\Parser\DocComment
 * - Created methods
 * @edit 18-01-02
 * - parse @ut_factory
 * - Created method: parseFactory()
 * @edit 18-01-20
 * - Updated parseFactory()
 * @version 0A.00
 * @edit 18-05-13
 * - Upgraded file structure and namespace
 * @version 0A.0F
 * @edit 18-05-19
 * - Revised Project packages
 * @version 0A.50
 * @edit 18-11-26
 * - Updated parseTag()
 * @version 0A.60
 * @todo
 * - Upgrade/verify structure for A1
 */
class DocComment extends \GIndie\Common\Parser\DocComment
{

    /**
     * 
     * @since 18-01-01
     * 
     * @param type $tagname
     * @param type $value
     * 
     * @edit 18-01-02
     * @edit 18-11-26
     * - Parse tag ut_skip
     */
    protected function parseTag($tagname, $value)
    {
        switch ($tagname)
        {
            case "ut_skip":
                $this->parsed["ut_skip"] = true;
                break;
            case "ut_str":
                $arrayTmp = \explode(" ", $value);
                $this->parsed["unit_test"][\array_shift($arrayTmp)]["expected"] = $this->parseUnitTestString($arrayTmp);
                break;
            case "ut_params":
                $arrayTmp = \explode(" ", $value);
                $this->parsed["unit_test"][\array_shift($arrayTmp)]["parameters"] = $this->parseParameters(\join(" ",
                                                                                                                 $arrayTmp));
                break;
            case "ut_factory":
                $arrayTmp = \explode(" ", $value);
                $this->parsed["unit_test"][\array_shift($arrayTmp)]["factory"] = $this->parseFactory($arrayTmp);
                break;
            default:
                parent::parseTag($tagname, $value);
                break;
        }
    }

    /**
     * 
     * @since 18-01-02
     * 
     * @param array $data
     * @return array
     * @edit 18-01-20
     * - Corrected bug
     */
    private function parseFactory(array $data)
    {
        $method = $data[0];
        $method = \explode("::", $method);
        if (\count($method) > 1) {
            $class = $method[0];
            $method = $method[1];
        } else {
            $class = null;
            $method = $method[0];
        }
        return ["class" => $class, "method" => $method, "testId" => $data[1]];
    }

    /**
     * @since 18-01-01
     * @param array $data
     * @return string
     */
    private function parseUnitTestString(array $data)
    {
        return \substr(\join(" ", $data), 1, -1);
    }

    /**
     * 
     * @param string $string
     * @return string
     * @since 18-01-20
     */
    private function parseParamString($string)
    {
        return \strstr(\substr($string, 1), '"', true);
    }

    /**
     * 
     * @param string $string
     * @return string
     * @since 18-01-20
     */
    private function parseParamTag($string)
    {
        return \substr($string, 0, \strstr('>', $string));
    }

    /**
     * 
     * @param string $string
     * @return string
     * @since 18-01-20
     */
    private function parseParamArray($string)
    {
        return \strstr(\substr($string, 1), ']', true);
    }

    /**
     * 
     * @param string $string
     * @return array
     * @since 18-01-20
     */
    private function parseParameters($string)
    {
        $rtnArray = [];
        while (\strlen($string) > 0) {
            switch (\substr($string, 0, 1))
            {
                case '"':
                    $parsedString = $this->parseParamString($string);
                    $rtnArray[] = $parsedString;
                    $string = \substr($string, \strlen($parsedString) + 2);
                    break;
                case ' ':
                    $string = \substr($string, 1);
                    break;
                case ',':
                    $string = \substr($string, 1);
                    break;
                case '[':
                    $parsedString = $this->parseParamArray($string);
                    $string = \substr($string, \strlen($parsedString) + 2);

                    /**
                     * @todo Validation of =>
                     */
                    if (\strstr($parsedString, "=>") !== false) {
                        $tmpArray = [];
                        foreach (\explode(",", $parsedString) as $tmpExploded) {
                            $tmpExploded2 = \explode("=>", $tmpExploded);
                            $key = $this->parseParameters($tmpExploded2[0]);
                            $key = $key[0];
                            $value = $this->parseParameters($tmpExploded2[1]);
                            $value = $value[0];
                            $tmpArray[$key] = $value;
                        }
                        $rtnArray[] = $tmpArray;
                    } else {
                        $rtnArray[] = $this->parseParameters($parsedString);
                    }
                    break;
                default:
                    break;
            }
        }
        return $rtnArray;
    }

    /**
     * @since 18-01-01
     * @param array $data
     * @return array
     */
    private function parseUnitTestParameters(array $data)
    {
        $rtnArray = [];
        foreach ($data as $tmp) {
            switch (0)
            {
                case \strcmp($tmp, "null"):
                    $rtnArray[] = "null";
                    break;

                default:
                    $rtnArray[] = $tmp;
                    break;
            }
        }
        return $rtnArray;
    }

}
