<?php

use Contao\System;
use ContaoDD\EventListener\ParseTemplateListener;
use Symfony\Component\HttpFoundation\Request;

/**
 * Backend Javascript
 */
if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
    if(!isset($GLOBALS['TL_JAVASCRIPT']['jquery'])) $GLOBALS['TL_JAVASCRIPT']['jquery'] = 'assets/jquery/js/jquery.min.js|static';
    if(!isset($GLOBALS['TL_JAVASCRIPT']['jquery-noconflict'])) $GLOBALS['TL_JAVASCRIPT']['jquery-noconflict'] = 'bundles/contaoddadvancedclasses/js/jquery.noconflict.js|static';
    $GLOBALS['TL_JAVASCRIPT']['advanced_classes'] = 'bundles/contaoddadvancedclasses/js/jquery.advanced_classes.js|static';
}

/**
 * Css
 */
if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
    if(!isset($GLOBALS['TL_CONFIG']['ac_disableCSS'])) $GLOBALS['TL_CONFIG']['ac_disableCSS'] = 0;
    if($GLOBALS['TL_CONFIG']['ac_disableCSS'] == 0) {
        $GLOBALS['TL_CSS']['advanced_classes'] = 'bundles/contaoddadvancedclasses/css/advanced_classes.css|static';
        $GLOBALS['TL_CSS']['font-awesome'] = 'bundles/contaoddadvancedclasses/vendor/fontello/css/icon.css|static';
    }
    $GLOBALS['TL_CSS']['advanced_classes_settings'] = 'bundles/contaoddadvancedclasses/css/advanced_classes_settings.css|static';
}
