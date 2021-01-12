<?php

/**
 * GI-ProjectHandler-DVLP - FileHandlerConstants 
 *
 * @copyright (CC) 2020 Angel Sierra Vega. Grupo INDIE.
 * @author Angel Sierra Vega <angel.sierra@grupoindie.com>
 *
 * @package GIndie\ProjectHandler\FileHandler
 * @version 0B.60
 * 
 * @since 18-05-18
 */

namespace GIndie\ProjectHandler\DataDefinition;

/**
 * 
 * @edit 18-09-18
 * - Upgraded class's Docblock
 * @edit 18-09-25
 * - Added FILETYPE_UNDEFINED
 * @edit 18-11-01
 * - Added FILETYPE_LOG
 */
interface FileHandlerConstants
{

    /**
     * @since 18-05-18
     */
    const FILETYPE_SCRIPT = "SCR";

    /**
     * @since 18-05-18
     */
    const FILETYPE_ABSTRACT_CLASS = "ABS";

    /**
     * @since 18-05-18
     */
    const FILETYPE_CLASS = "CLA";

    /**
     * @since 18-05-18
     */
    const FILETYPE_TRAIT = "TRA";

    /**
     * @since 18-05-18
     */
    const FILETYPE_INTERFACE = "INT";

    /**
     * @since 18-09-25
     */
    const FILETYPE_UNDEFINED = "NDF";
    
    /**
     * @since 18-11-01
     */
    const FILETYPE_LOG = "LOG";

}
