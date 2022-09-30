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

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;

#[AsCallback(table: 'tl_page', target: 'fields.ac_set.options')]
#[AsCallback(table: 'tl_form', target: 'fields.ac_set.options')]
class AcSetListener
{
    use ListenerHelperTrait;

    public function __invoke(): array
    {
        // add custom sets
        if (isset($GLOBALS['customAdvancedClassesSets']) && \is_array($GLOBALS['customAdvancedClassesSets'])) {
            $this->sets = array_merge($this->sets, $GLOBALS['customAdvancedClassesSets']);
        }

        return $this->sets;
    }
}
