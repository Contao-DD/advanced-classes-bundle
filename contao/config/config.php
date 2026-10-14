<?php

use Contao\System;
use Symfony\Component\HttpFoundation\Request;

/**
 * Backend Javascript
 */
if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
    $GLOBALS['TL_JAVASCRIPT']['advanced_classes'] = 'bundles/contaoddadvancedclasses/js/advanced_classes.js|static';
}

$GLOBALS['TL_PERMISSIONS'][] = 'advancedCss';
