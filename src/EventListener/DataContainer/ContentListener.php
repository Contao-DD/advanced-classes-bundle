<?php

declare(strict_types=1);

/*
 * advanced-classes-bundle for Contao Open Source CMS
 *
 * Copyright (c) 2022 Contao Stammtisch Dresden
 *
 * @package advanced-classes
 * @author Mathias Arzberger <develop@pdir.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace ContaoDD\AdvancedClassesBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Symfony\Component\HttpFoundation\RequestStack;

class ContentListener
{
    use ListenerHelperTrait;

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[AsCallback(table: 'tl_content', target: 'config.onload')]
    public function onLoad(DataContainer $dc = null): void
    {
        $this->manipulateDca($dc, 'cssID;');
        $this->manipulateDca($dc, 'useHomeDir;');
    }

    #[AsCallback(table: 'tl_content', target: 'fields.advancedCss.xlabel')]
    public function onXlabel(DataContainer $dc): string
    {
        $config = $this->getConfigOfRootPageByContentElementId($dc->activeRecord->pid);

        return $this->generateScriptTag($config);
    }
}
