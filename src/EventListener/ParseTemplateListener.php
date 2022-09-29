<?php

declare(strict_types=1);

/*
 * advanced-classes-bundle for Contao Open Source CMS
 *
 * Copyright (c) 2022 Contao Stammtisch Dresden
 *
 * @package advanced-classes
 * @author Mathias Arzberger <develop@pdir.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace ContaoDD\AdvancedClassesBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;

#[AsHook('parseTemplate')]
class ParseTemplateListener
{
    /*
     * manipulate the given template object to add advanced css to the existing css class
     */
    public function __invoke($template): void
    {
        if (!isset($template->advancedCss) || '' === $template->advancedCss) {
            return;
        }

        $template->class .= ' '.$template->advancedCss;
    }
}
