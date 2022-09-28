<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

$date = date('Y');

$GLOBALS['ecsHeader'] = <<<EOF
advanced-classes-bundle for Contao Open Source CMS

Copyright (c) $date Contao Stammtisch Dresden

@package advanced-classes
@author Mathias Arzberger <develop@pdir.de>
@license http://www.gnu.org/licences/lgpl-3.0.html LGPL
EOF;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__.'/vendor/contao/easy-coding-standard/config/set/contao.php');

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::LINE_ENDING, "\n");

    $services = $containerConfigurator->services();
    $services
        ->set(HeaderCommentFixer::class)
        ->call('configure', [[
            'header' => $GLOBALS['ecsHeader'],
        ]])
    ;
};
