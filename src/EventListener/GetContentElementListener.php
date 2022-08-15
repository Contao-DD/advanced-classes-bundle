<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Contao Stammtisch Dresden
 * @package advanced-classes
 * @author Mathias Arzberger <develop@pdir.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace ContaoDD\AdvancedClassesBundle\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\ContentElement;
use Contao\ContentModel;

/**
 * @Hook("getContentElement")
 */
class ParseTemplateListener
{
    /*
     * manipulate the given template object to add advanced css to the existing css class
     */
    public function __invoke(ContentModel $contentModel, string $buffer, $element): string
    {
        if($contentModel->type == 'form' && $contentModel->advancedCss != '') {
            $buffer = str_replace('class="ce_form', 'class="ce_form '.$contentModel->advancedCss, $buffer);
        }

        if($contentModel->type == 'module' && $contentModel->advancedCss != '') {
            $buffer = str_replace('class="mod_', 'class="'.$contentModel->advancedCss.' mod_', $buffer);
        }

        return $buffer;
    }
}