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
class PageListener
{
    public function __invoke(): array
    {
        dump('tl_page');

        $sets = [];

        $sets[] = 'bundles/contaoddadvancedclasses/sets/bootstrap2.json';
        $sets[] = 'bundles/contaoddadvancedclasses/sets/bootstrap3.json';
        $sets[] = 'bundles/contaoddadvancedclasses/sets/bootstrap4-alpha.json';
        $sets[] = 'bundles/contaoddadvancedclasses/sets/bootstrap4.json';
        $sets[] = 'bundles/contaoddadvancedclasses/sets/materialize.json';
        $sets[] = 'bundles/contaoddadvancedclasses/sets/bulma.json';
        $sets[] = 'bundles/contaoddadvancedclasses/sets/spectre.json';

        // add custom sets
        if (isset($GLOBALS['customAdvancedClassesSets']) && \is_array($GLOBALS['customAdvancedClassesSets'])) {
            $sets = array_merge($sets, $GLOBALS['customAdvancedClassesSets']);
        }

        return $sets;
    }
}
