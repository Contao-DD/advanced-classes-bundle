<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2022 Contao Stammtisch Dresden
 * @package advanced-classes
 * @author Mathias Arzberger <develop@pdir.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

$GLOBALS['TL_DCA']['tl_form']['fields']['advancedCss'] = [
    'label' => $GLOBALS['TL_LANG']['MSC']['advanced_classes_legend'],
    'exclude' => true,
    'search' => false,
    'inputType' => 'text',
    'eval' => ['maxlength' => 255],
    'sql' => "varchar(255) NOT NULL default ''"
];
