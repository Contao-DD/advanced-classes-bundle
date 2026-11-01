<?php

declare(strict_types=1);

/*
 * advanced-classes-bundle for Contao Open Source CMS
 *
 * Copyright (c) 2026 Contao Stammtisch Dresden
 *
 * @package advanced-classes
 * @author Mathias Arzberger <develop@pdir.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace ContaoDD\AdvancedClassesBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Symfony\Component\HttpFoundation\RequestStack;

class FormFieldListener
{
    use ListenerHelperTrait;

    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    #[AsCallback(table: 'tl_form_field', target: 'config.onload')]
    public function onLoad(DataContainer|null $dc = null): void
    {
        if (null === $dc) {
            return;
        }

        $this->manipulateDca($dc, 'class');
    }

    #[AsCallback(table: 'tl_form_field', target: 'fields.advancedCss.xlabel')]
    public function onXlabel(DataContainer $dc): string
    {
        $pid = $dc->getCurrentRecord()['pid'] ?? null;

        return $this->generateScriptTag($pid ? $this->getConfigOfFormId($pid) : null);
    }
}
