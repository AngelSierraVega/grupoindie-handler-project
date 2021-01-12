<?php

namespace GIndie\ProjectHandler\Handler;

/**
 * Description of ReflectionInterface
 *
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 *
 * @package GIndie\ProjectHandler\UnitTest
 *
 * @since 18-01-03
 * @edit 18-01-03
 * - Moved in methods.
 * @version 0A.00
 * @edit 18-05-13
 * - Upgraded file structure and namespace
 * @version 0A.0F
 * @todo
 * - Upgrade/verify structure for A1
 */
interface ReflectionInterface
{

    /**
     * 
     * @since 18-01-03
     */
    public function getDocComments();

    /**
     * @since 18-01-03
     */
    public function requiredTags();
    
    /**
     * 
     * @since 18-01-03
     * @param type $tagname
     * @param type $colspan
     */
    public function validateTag($tagname, $colspan = "1");
    
}
