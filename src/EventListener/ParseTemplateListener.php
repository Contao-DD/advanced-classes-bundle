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
use Contao\Template;

/**
 * @Hook("parseTemplate")
 */
class ParseTemplateListener
{
    /*
     * manipulate the given template object to add advanced css to the existing css class
     */
    public function __invoke(Template $template): void
    {
        $arrData = $template->getData();

        if (!isset($arrData['advancedCss']))
            return;

        $template->class .= ' ' . $arrData['advancedCss'];

    }
}