<?php

/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'ContaoDD',
));


/**
 * Register the classes
 */

ClassLoader::addClasses(array
(
    // Classes
    'ContaoDD\AdvancedClassesHooks'   => 'vendor/gondao/advancedclasses-bundle/src/Resources/contao/classes/AdvancedClassesHooks.php',
));
