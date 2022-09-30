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