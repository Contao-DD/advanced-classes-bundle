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
    private string $projectDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->projectDir = sys_get_temp_dir().'/advanced-classes-'.bin2hex(random_bytes(4));

        mkdir($this->projectDir.'/files/sets', 0777, true);
        mkdir($this->projectDir.'/public', 0777, true);

        file_put_contents($this->projectDir.'/files/sets/custom.json', '{"title": "My Custom Set"}');
        file_put_contents($this->projectDir.'/files/sets/untitled.json', '{"sections": {}}');
        file_put_contents($this->projectDir.'/files/sets/invalid.json', '{invalid');
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['customAdvancedClassesSets']);

        foreach (glob($this->projectDir.'/files/sets/*') as $file) {
            unlink($file);
        }

        rmdir($this->projectDir.'/files/sets');
        rmdir($this->projectDir.'/files');
        rmdir($this->projectDir.'/public');
        rmdir($this->projectDir);

        parent::tearDown();
    }

    public function testReturnsTitlesOfBundledSets(): void
    {
        $options = $this->createListener()();

        $this->assertSame(
            [
                'bundles/contaoddadvancedclasses/sets/bootstrap4.json' => 'Bootstrap 4',
                'bundles/contaoddadvancedclasses/sets/bootstrap5.json' => 'Bootstrap 5',
                'bundles/contaoddadvancedclasses/sets/materialize.json' => 'Materialize',
                'bundles/contaoddadvancedclasses/sets/bulma.json' => 'Bulma',
                'bundles/contaoddadvancedclasses/sets/spectre.json' => 'Spectre',
            ],
            $options,
        );
    }

    public function testReturnsTitlesOfCustomSets(): void
    {
        $GLOBALS['customAdvancedClassesSets'] = [
            '/files/sets/custom.json',
            '/files/sets/untitled.json',
            '/files/sets/invalid.json',
            '/files/sets/missing.json',
        ];

        $options = $this->createListener()();

        $this->assertSame('My Custom Set', $options['/files/sets/custom.json']);
        $this->assertSame('untitled.json', $options['/files/sets/untitled.json']);
        $this->assertSame('invalid.json', $options['/files/sets/invalid.json']);
        $this->assertSame('missing.json', $options['/files/sets/missing.json']);
    }

    public function testCustomSetsAreNotAddedTwice(): void
    {
        $GLOBALS['customAdvancedClassesSets'] = ['/files/sets/custom.json'];

        $listener = $this->createListener();
        $first = $listener();
        $second = $listener();

        $this->assertSame($first, $second);
        $this->assertCount(6, $second);
    }

    private function createListener(): AcSetListener
    {
        return new AcSetListener($this->projectDir, $this->projectDir.'/public');
    }
}
