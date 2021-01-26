<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Contao Stammtisch Dresden
 * @package advanced-classes
 * @author Mathias Arzberger <develop@pdir.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$dc = &$GLOBALS['TL_DCA']['tl_form'];

foreach ($dc['palettes'] as $key=>$value) {
    if(!is_array ($value) && strpos($value,"cssID;")!==false) {
        $dc['palettes'][$key] = str_replace('cssID;', 'cssID;{advanced_classes_legend},advancedCss;', $value);
    }
}

$arrFields = array
(
    'advancedCss' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_content']['advancedCss'],
        'exclude'                 => true,
        'search'                  => false,
        'inputType'               => 'text',
        'eval'                    => array('maxlength'=>255),
        'sql'                     => "varchar(255) NOT NULL default ''"
    ),
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);
