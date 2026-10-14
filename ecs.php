<?php

declare(strict_types=1);

use Contao\EasyCodingStandard\Set\SetList;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

$header = <<<'EOF'
    advanced-classes-bundle for Contao Open Source CMS

    Copyright (c) 2026 Contao Stammtisch Dresden

    @package advanced-classes
    @author Mathias Arzberger <develop@pdir.de>
    @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
    EOF;

return ECSConfig::configure()
    ->withSets([SetList::CONTAO])
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withConfiguredRule(HeaderCommentFixer::class, ['header' => $header])
    ->withSpacing(lineEnding: "\n")
;
