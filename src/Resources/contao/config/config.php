<?php

/**
 * General settings
 */

$GLOBALS['TL_CONFIG']['advancedClassesSet'] = 'both';

/**
 * add default sets
 *
 * hint: add update save json files via own extension or use default localconfig.php file
 * use $GLOBALS['TL_CONFIG']['advancedClassesSets'][] = '/files/theme/myCssSet.json';
 *
 */
if(TL_MODE == 'BE')
{
    if (!isset($GLOBALS['TL_CONFIG']['advancedClassesSets']))
    {
        $GLOBALS['TL_CONFIG']['advancedClassesSets'] = [];
    }
    $GLOBALS['TL_CONFIG']['advancedClassesSets'][] = 'bundles/contaoddadvancedclasses/sets/bootstrap2.json';
    $GLOBALS['TL_CONFIG']['advancedClassesSets'][] = 'bundles/contaoddadvancedclasses/sets/bootstrap3.json';
    $GLOBALS['TL_CONFIG']['advancedClassesSets'][] = 'bundles/contaoddadvancedclasses/sets/bootstrap4-alpha.json';
    $GLOBALS['TL_CONFIG']['advancedClassesSets'][] = 'bundles/contaoddadvancedclasses/sets/bootstrap4.json';
    $GLOBALS['TL_CONFIG']['advancedClassesSets'][] = 'bundles/contaoddadvancedclasses/sets/materialize.json';
    $GLOBALS['TL_CONFIG']['advancedClassesSets'][] = 'bundles/contaoddadvancedclasses/sets/bulma.json';
    $GLOBALS['TL_CONFIG']['advancedClassesSets'][] = 'bundles/contaoddadvancedclasses/sets/spectre.json';
}

/**
 * Hooks
 */

$GLOBALS['TL_HOOKS']['parseTemplate'][] = ['\ContaoDD\AdvancedClassesHooks', 'extendCssClasses'];
$GLOBALS['TL_HOOKS']['outputBackendTemplate'][] = ['\ContaoDD\AdvancedClassesHooks', 'extendBackendTemplate'];
$GLOBALS['TL_HOOKS']['getContentElement'][] = ['\ContaoDD\AdvancedClassesHooks', 'extendContentElementCssClasses'];

/**
 * Backend Javascript
 */
if (TL_MODE == 'BE') {
    if(!isset($GLOBALS['TL_JAVASCRIPT']['jquery'])) $GLOBALS['TL_JAVASCRIPT']['jquery'] = 'assets/jquery/js/jquery.min.js|static';
    if(!isset($GLOBALS['TL_JAVASCRIPT']['jquery-noconflict'])) $GLOBALS['TL_JAVASCRIPT']['jquery-noconflict'] = 'bundles/contaoddadvancedclasses/js/jquery.noconflict.js|static';
    $GLOBALS['TL_JAVASCRIPT']['advanced_classes'] = 'bundles/contaoddadvancedclasses/js/jquery.advanced_classes.js|static';
}

/**
 * Css
 */
if (TL_MODE == 'BE') {
    if(!isset($GLOBALS['TL_CONFIG']['ac_disableCSS'])) $GLOBALS['TL_CONFIG']['ac_disableCSS'] = 0;
    if($GLOBALS['TL_CONFIG']['ac_disableCSS'] == 0) {
        $GLOBALS['TL_CSS']['advanced_classes'] = 'bundles/contaoddadvancedclasses/css/advanced_classes.css|static';
        $GLOBALS['TL_CSS']['font-awesome'] = 'bundles/contaoddadvancedclasses/vendor/fontello/css/icon.css|static';
    }
    $GLOBALS['TL_CSS']['advanced_classes_settings'] = 'bundles/contaoddadvancedclasses/css/advanced_classes_settings.css|static';
}
