<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Contao Stammtisch Dresden
 * @package advanced-classes
 * @author Mathias Arzberger <develop@pdir.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace ContaoDD;

class AdvancedClassesHooks extends \Controller
{
    /*
     * manipulate the given template object to add advanced css to the existing css class
     */
    public function extendCssClasses($objTemplate)
    {
        $arrData = $objTemplate->getData();
        if (isset($arrData['advancedCss'])) {
            $objTemplate->class .= ' ' . $arrData['advancedCss'];
        }
    }

    /*
     * add the varibale for dataset source file to backend
     */
    public function extendBackendTemplate($strContent, $strTemplate)
    {
        if ($strTemplate == 'be_main')
        {
            $strScript = "<script>var advancedClassesSet = '".$GLOBALS['TL_CONFIG']['advancedClassesSet']."';</script>\n\r</body>";
            return str_replace('</body>', $strScript, $strContent);
        }
        return $strContent;
    }
}