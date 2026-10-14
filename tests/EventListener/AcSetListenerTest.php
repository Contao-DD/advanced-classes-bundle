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

namespace ContaoDD\AdvancedClassesBundle\Tests\EventListener;

use ContaoDD\AdvancedClassesBundle\EventListener\DataContainer\AcSetListener;
use PHPUnit\Framework\TestCase;

class AcSetListenerTest extends TestCase
{
    protected function tearDown(): void
    {
        unset($GLOBALS['customAdvancedClassesSets']);

        parent::tearDown();
    }

    public function testCustomSetsAreNotAddedTwice(): void
    {
        $GLOBALS['customAdvancedClassesSets'] = ['/files/sets/custom.json'];

        $listener = new AcSetListener();
        $first = $listener();
        $second = $listener();

        $this->assertSame($first, $second);
        $this->assertSame(1, array_count_values($second)['/files/sets/custom.json']);
    }
}
