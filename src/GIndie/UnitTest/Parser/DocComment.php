<?php

/**
 * UnitTest - DocComment
 *
 */

namespace GIndie\UnitTest\Parser;

/**
 * Description of DocComment
 *
 * @copyright (C) 2018 Angel Sierra Vega. Grupo INDIE.
 * @package UnitTest
 *
 * @version UT.00.00 18-01-01 Dummie class created
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @edit UT.00.01
 * - Extend from \GIndie\Common\Parser\DocComment
 * - Created methods
 */
class DocComment extends \GIndie\Common\Parser\DocComment
{

    /**
     * 
     * @param type $tagname
     * @param type $value
     * @since UT.00.01
     */
    protected function parseTag($tagname, $value)
    {
        switch ($tagname)
        {
            case "ut_str":
                $arrayTmp = \explode(" ", $value);
                $this->parsed["unit_test"][\array_shift($arrayTmp)]["expected"] = $this->parseUnitTestString($arrayTmp);
                break;
            case "ut_params":
                $arrayTmp = \explode(" ", $value);
                $this->parsed["unit_test"][\array_shift($arrayTmp)]["parameters"] = $this->parseUnitTestParameters($arrayTmp);
                break;
            default:
                parent::parseTag($tagname, $value);
                break;
        }
    }

    /**
     * @since UT.00.01
     * @param array $data
     * @return string
     */
    private function parseUnitTestString(array $data)
    {
        return \substr(\join(" ", $data), 1, -1);
    }

    /**
     * @since UT.00.01
     * @param array $data
     * @return array
     */
    private function parseUnitTestParameters(array $data)
    {
        $rtnArray = [];
        foreach ($data as $tmp) {
            switch (0)
            {
                case \strpos($tmp, '"'):
                    $rtnArray[] = \substr($tmp, 1, -1);
                    break;
                case \strpos($tmp, '['):
                    $tmpArray = \explode(",", \substr($tmp, 1, -1));
                    if (\strstr($tmp, "=>") !== false) {
                        foreach ($tmpArray as $tmpExploded) {
                            $tmpExploded2 = \explode("=>", $tmpExploded);
                            $key = $this->parseUnitTestParameters([\array_shift($tmpExploded2)]);
                            $key = $key[0];
                            $value = $this->parseUnitTestParameters($tmpExploded2);
                            $value = \join("", $value);
                            $rtnArray[] = [$key => $value];
                        }
                    } else {
                        $rtnArray[] = $this->parseUnitTestParameters($tmpArray);
                    }

                    break;

                default:
                    $rtnArray[] = $tmp;
                    break;
            }
        }
        return $rtnArray;
    }

}
