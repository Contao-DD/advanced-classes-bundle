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

namespace ContaoDD\AdvancedClassesBundle\Tests;

use ContaoDD\AdvancedClassesBundle\DependencyInjection\ContaoDDAdvancedClassesExtension;
use PHPUnit\Framework\TestCase;

class ContaoDDAdvancedClassesBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new ContaoDDAdvancedClassesExtension();

        $this->assertInstanceOf('ContaoDD\AdvancedClassesBundle\ContaoDDAdvancedClassesExtension', $bundle);
    }
}
