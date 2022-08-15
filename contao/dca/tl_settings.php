<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2015 Contao Stammtisch Dresden
 * @package advanced-classes
 * @author Mathias Arzberger <develop@pdir.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

use Contao\Backend;

$dc = &$GLOBALS['TL_DCA']['tl_settings'];

$dc['palettes']['default'] = str_replace('maxResultsPerPage;', 'maxResultsPerPage;{ac_legend},advancedClassesSet,ac_defaultColumnWidth,ac_disableCSS;', $dc['palettes']['default']);

$arrFields = array
(
    'advancedClassesSet' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['advancedClassesSet'],
        'inputType'               => 'select',
        'options_callback'        => array('tl_settings_advanced_classes', 'getAvailableSetFiles'),
        'reference'               => &$GLOBALS['TL_LANG']['tl_settings'],
        'eval'                    => array('tl_class'=>'w50')
    ),
    'ac_defaultColumnWidth' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['ac_defaultColumnWidth'],
        'inputType'               => 'checkbox',
        'eval'                    => array('tl_class'=>'w50')
    ),
    'ac_disableCSS' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['ac_disableCSS'],
        'inputType'               => 'checkbox',
        'eval'                    => array('tl_class'=>'w50')
    )
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);


/**
 * Class tl_settings_advanced_classes
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * Copyright (c) 2015 Contao Stammtisch Dresden
 * @package advanced-classes
 * @author Mathias Arzberger <develop@pdir.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

class tl_settings_advanced_classes extends Backend
{
    /**
     * Return all available sets
     * @return array
     */
    public function getAvailableSetFiles(): array
    {
        $arrSets = [];
        foreach ($GLOBALS['TL_CONFIG']['advancedClassesSets'] as $key => $value)
        {
            if(!strpos($value,"system/")!==false)
            {
                $arrSets[$value] = basename( $value ) . ' (custom)';
                continue;
            }
            $arrSets[$value] = basename( $value );

        }
        return $arrSets;
    }
}