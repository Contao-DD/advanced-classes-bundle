<?php

/**
 * General settings
 */

$GLOBALS['TL_CONFIG']['advancedClassesSet'] = 'both';

/**
 * Hooks
 */

$GLOBALS['TL_HOOKS']['parseTemplate'][] = array('\ContaoDD\AdvancedClassesHooks', 'extendCssClasses');
$GLOBALS['TL_HOOKS']['outputBackendTemplate'][] = array('\ContaoDD\AdvancedClassesHooks', 'extendBackendTemplate');

/**
 * Backend Javascript
 */
if (TL_MODE == 'BE') {
    $GLOBALS['TL_JAVASCRIPT']['jquery'] = 'assets/jquery/js/jquery.min.js';
    $GLOBALS['TL_JAVASCRIPT']['noconflict'] = 'bundles/gondaoadvancedclasses/js/jquery.noconflict.js';
    $GLOBALS['TL_JAVASCRIPT']['advanced_classes'] = 'bundles/gondaoadvancedclasses/js/jquery.advanced_classes.js';
}

/**
 * Css
 */
if (TL_MODE == 'BE') {
    $GLOBALS['TL_CSS']['advanced_classes'] = 'bundles/gondaoadvancedclasses/css/advanced_classes.css';
    $GLOBALS['TL_CSS']['font-awesome'] = 'bundles/gondaoadvancedclasses/vendor/fontello/css/icon.css';
}
