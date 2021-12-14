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

        if (!isset($arrData['advancedCss']))
            return;

        $objTemplate->class .= ' ' . $arrData['advancedCss'];

    }

    public function extendContentElementCssClasses($objElement, $strBuffer)
    {
        $css = $objElement->get('advancedCss');
        return '<div class="content-element '.$css.'">' . $strBuffer . '</div>';
    }

    public function extendFormCssClasses($contentModel, $buffer, $element)
    {
        if($contentModel->type == 'form' && $contentModel->advancedCss != '') {
            $buffer = str_replace('class="ce_form', 'class="ce_form '.$contentModel->advancedCss, $buffer);
        }

        if($contentModel->type == 'module' && $contentModel->advancedCss != '') {
            $buffer = str_replace('class="mod_', 'class="'.$contentModel->advancedCss.' mod_', $buffer);
        }

        return $buffer;
    }

    /*
     * add the varibale for dataset source file to backend
     */
    public function extendBackendTemplate($strContent, $strTemplate)
    {
        if ($strTemplate == 'be_main')
        {
            if(!isset($GLOBALS['TL_CONFIG']['ac_defaultColumnWidth'])) $GLOBALS['TL_CONFIG']['ac_defaultColumnWidth'] = '';
            $strScript = "<script>var advancedClassesSet = '".$GLOBALS['TL_CONFIG']['advancedClassesSet']."';var defaultColumnWidth = '".$GLOBALS['TL_CONFIG']['ac_defaultColumnWidth']."';</script>\n\r</body>";
            return str_replace('</body>', $strScript, $strContent);
        }
        return $strContent;
    }
}