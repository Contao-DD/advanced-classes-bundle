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

namespace ContaoDD\AdvancedClassesBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContaoDDAdvancedClassesExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('listener.yaml');
        $loader->load('services.yaml');
    }
}
