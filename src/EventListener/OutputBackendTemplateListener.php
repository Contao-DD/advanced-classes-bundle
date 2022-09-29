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

#[AsHook('outputBackendTemplate')]
class OutputBackendTemplateListener
{
    /*
     * add the variable for dataset source file to backend
     */
    public function __invoke(string $buffer, string $template): string
    {
        if ('be_main' === $template) {
            if (!isset($GLOBALS['TL_CONFIG']['ac_defaultColumnWidth'])) {
                $GLOBALS['TL_CONFIG']['ac_defaultColumnWidth'] = '';
            }

            $strScript = "<script>var advancedClassesSet = '".$GLOBALS['TL_CONFIG']['advancedClassesSet']."';var defaultColumnWidth = '".$GLOBALS['TL_CONFIG']['ac_defaultColumnWidth']."';</script></body>";

            return str_replace('</body>', $strScript, $buffer);
        }

        return $buffer;
    }
}
