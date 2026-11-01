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

use Contao\ContentModel;
use ContaoDD\AdvancedClassesBundle\EventListener\GetContentElementListener;
use PHPUnit\Framework\TestCase;

class GetContentElementListenerTest extends TestCase
{
    /**
     * @dataProvider bufferProvider
     */
    public function testAddsAdvancedCss(string $advancedCss, string $buffer, string $expected): void
    {
        $model = $this->createMock(ContentModel::class);
        $model
            ->method('__get')
            ->willReturnCallback(static fn (string $key) => 'advancedCss' === $key ? $advancedCss : null)
        ;

        $this->assertSame($expected, (new GetContentElementListener())($model, $buffer, null));
    }

    public static function bufferProvider(): iterable
    {
        yield 'empty advanced css' => [
            '',
            '<div class="content-text">',
            '<div class="content-text">',
        ];

        yield 'prepends classes' => [
            'col-6 d-none',
            '<div class="content-text">',
            '<div class="col-6 d-none content-text">',
        ];

        yield 'only modifies the first class attribute' => [
            'col-6',
            '<div class="content-text"><p class="lead">',
            '<div class="col-6 content-text"><p class="lead">',
        ];

        yield 'does not duplicate existing classes' => [
            'col-6 d-none',
            '<div class="content-text col-6">',
            '<div class="d-none content-text col-6">',
        ];

        yield 'is not fooled by substrings' => [
            'col-1',
            '<div class="content-text"><span class="col-12">',
            '<div class="col-1 content-text"><span class="col-12">',
        ];

        yield 'adds class to outer element if a nested element already has it' => [
            'col-xl-6',
            '<div class="content-element-group"><div class="col-xl-6 content-element-group"><p>x</p></div></div>',
            '<div class="col-xl-6 content-element-group"><div class="col-xl-6 content-element-group"><p>x</p></div></div>',
        ];

        yield 'without class attribute' => [
            'col-6',
            '<div>',
            '<div>',
        ];
    }
}
