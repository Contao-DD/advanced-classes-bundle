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

namespace ContaoDD\AdvancedClassesBundle\EventListener\DataContainer;

use Contao\DataContainer;

trait ListenerHelperTrait
{
    private function manipulateDca(DataContainer $dc, $field): void
    {
        if (!$dc->id || 'edit' !== $this->requestStack->getCurrentRequest()->query->get('act')) {
            return;
        }

        $dc = &$GLOBALS['TL_DCA'][$dc->table];

        foreach ($dc['palettes'] as $key => $value) {
            if ('__selector__' === $value) {
                continue;
            }

            if (!\is_array($value) && str_contains($value, $field)) {
                $dc['palettes'][$key] = str_replace($field, $field.';{advanced_classes_legend},advancedCss;', $value);
            }
        }
    }
}
