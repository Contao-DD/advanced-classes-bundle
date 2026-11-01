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

use Contao\Form;
use Contao\FormFieldsetStart;
use Contao\FormText;
use Contao\Widget;
use ContaoDD\AdvancedClassesBundle\EventListener\LoadFormFieldListener;
use PHPUnit\Framework\TestCase;

class LoadFormFieldListenerTest extends TestCase
{
    public function testAddsTheClassesToThePrefix(): void
    {
        $widget = $this->createWidget(FormText::class, 'col-6 d-none');

        (new LoadFormFieldListener())($widget, 'form', [], $this->createForm('set.json'));

        $this->assertSame('widget widget-text col-6 d-none', $widget->prefix);
    }

    public function testAddsTheClassesToTheClassOfFieldsets(): void
    {
        $widget = $this->createWidget(FormFieldsetStart::class, 'col-6');

        (new LoadFormFieldListener())($widget, 'form', [], $this->createForm('set.json'));

        $this->assertSame('my-fieldset col-6', $widget->class);
    }

    public function testDoesNothingWithoutSet(): void
    {
        $widget = $this->createWidget(FormText::class, 'col-6');

        (new LoadFormFieldListener())($widget, 'form', [], $this->createForm(''));

        $this->assertSame('widget widget-text', $widget->prefix);
    }

    public function testDoesNothingWithoutAdvancedCss(): void
    {
        $widget = $this->createWidget(FormText::class, null);

        (new LoadFormFieldListener())($widget, 'form', [], $this->createForm('set.json'));

        $this->assertSame('widget widget-text', $widget->prefix);
    }

    /**
     * @param class-string<Widget> $class
     */
    private function createWidget(string $class, string|null $advancedCss): Widget
    {
        $data = [
            'prefix' => 'widget widget-text',
            'class' => 'my-fieldset',
            'advancedCss' => $advancedCss,
        ];

        $widget = $this
            ->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->onlyMethods(['__get', '__set'])
            ->getMock()
        ;

        $widget
            ->method('__get')
            ->willReturnCallback(
                static function (string $key) use (&$data) {
                    return $data[$key] ?? null;
                },
            )
        ;

        $widget
            ->method('__set')
            ->willReturnCallback(
                static function (string $key, $value) use (&$data): void {
                    $data[$key] = $value;
                },
            )
        ;

        return $widget;
    }

    private function createForm(string $set): Form
    {
        $form = $this->createMock(Form::class);
        $form
            ->method('__get')
            ->willReturnCallback(static fn (string $key) => 'ac_set' === $key ? $set : null)
        ;

        return $form;
    }
}
