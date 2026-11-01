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

use Contao\DataContainer;
use ContaoDD\AdvancedClassesBundle\EventListener\DataContainer\ContentListener;
use ContaoDD\AdvancedClassesBundle\EventListener\DataContainer\FormFieldListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PaletteManipulationTest extends TestCase
{
    protected function tearDown(): void
    {
        unset($GLOBALS['TL_DCA']);

        parent::tearDown();
    }

    public function testAddsTheFieldToContentElementsWithCssId(): void
    {
        $GLOBALS['TL_DCA']['tl_content']['palettes'] = [
            '__selector__' => ['addImage'],
            'default' => '{type_legend},type',
            'text' => '{type_legend},type,headline;{text_legend},text;{expert_legend:hide},cssID;{invisible_legend:hide},invisible',
            'downloads' => '{type_legend},type;{source_legend},multiSRC,useHomeDir;{expert_legend:hide},cssID;{invisible_legend:hide},invisible',
            'html' => '{type_legend},type;{text_legend},html;{invisible_legend:hide},invisible',
        ];

        $listener = new ContentListener($this->createRequestStack('edit'));
        $listener->onLoad($this->createDataContainer('tl_content'));

        // Calling the listener again must not add the field twice
        $listener->onLoad($this->createDataContainer('tl_content'));

        $palettes = $GLOBALS['TL_DCA']['tl_content']['palettes'];

        $this->assertSame(['addImage'], $palettes['__selector__']);
        $this->assertSame('{type_legend},type', $palettes['default']);
        $this->assertSame('{type_legend},type,headline;{text_legend},text;{expert_legend:hide},cssID;{advanced_classes_legend},advancedCss;{invisible_legend:hide},invisible', $palettes['text']);
        $this->assertSame(1, substr_count($palettes['downloads'], 'advancedCss'));
        $this->assertStringNotContainsString('advancedCss', $palettes['html']);
    }

    public function testAddsTheFieldToFormFieldsWithClass(): void
    {
        $GLOBALS['TL_DCA']['tl_form_field']['palettes'] = [
            'text' => '{type_legend},type,name,label;{expert_legend:hide},class,value,placeholder,accesskey;{invisible_legend:hide},invisible',
            'radio' => '{type_legend},type,name,label;{options_legend},options;{expert_legend:hide},class;{invisible_legend:hide},invisible',
            'hidden' => '{type_legend},type,name,value;{invisible_legend:hide},invisible',
        ];

        (new FormFieldListener($this->createRequestStack('edit')))->onLoad($this->createDataContainer('tl_form_field'));

        $palettes = $GLOBALS['TL_DCA']['tl_form_field']['palettes'];

        $this->assertStringContainsString('{expert_legend:hide},class;{advanced_classes_legend},advancedCss;', $palettes['radio']);
        $this->assertStringContainsString('accesskey;{advanced_classes_legend},advancedCss;', $palettes['text']);
        $this->assertStringNotContainsString('advancedCss', $palettes['hidden']);
    }

    public function testDoesNothingOutsideTheEditMode(): void
    {
        $palette = '{type_legend},type;{expert_legend:hide},cssID';
        $GLOBALS['TL_DCA']['tl_content']['palettes'] = ['text' => $palette];

        (new ContentListener($this->createRequestStack(null)))->onLoad($this->createDataContainer('tl_content'));

        $this->assertSame($palette, $GLOBALS['TL_DCA']['tl_content']['palettes']['text']);
    }

    private function createRequestStack(string|null $act): RequestStack
    {
        $requestStack = new RequestStack();
        $requestStack->push(new Request(null === $act ? [] : ['act' => $act]));

        return $requestStack;
    }

    private function createDataContainer(string $table): DataContainer
    {
        $dc = $this->createMock(DataContainer::class);
        $dc
            ->method('__get')
            ->willReturnMap([
                ['id', 1],
                ['table', $table],
            ])
        ;

        return $dc;
    }
}
