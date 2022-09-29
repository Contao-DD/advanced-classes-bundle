<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2022 Contao Stammtisch Dresden
 * @package advanced-classes
 * @author Mathias Arzberger <develop@pdir.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;

PaletteManipulator::create()
    ->addLegend('ac_legend', 'layout_legend')

    ->addField('ac_set', 'ac_legend',PaletteManipulator::POSITION_APPEND)
    ->addField('ac_defaultColumnWidth', 'ac_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('ac_disableCSS', 'ac_legend', PaletteManipulator::POSITION_APPEND)

    ->applyToPalette('root', 'tl_page')
    ->applyToPalette('rootfallback', 'tl_page');

$GLOBALS['TL_DCA']['tl_page']['fields']['ac_set'] = [
    'inputType' => 'select',
    'reference' => &$GLOBALS['TL_LANG']['tl_page'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['ac_defaultColumnWidth'] = [
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50 clr'],
    'sql' => ['type' => 'boolean', 'default' => false]
];

$GLOBALS['TL_DCA']['tl_page']['fields']['ac_disableCSS'] = [
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => ['type' => 'boolean', 'default' => false]
];