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

namespace ContaoDD\AdvancedClassesBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Form;
use Contao\FormFieldsetStart;
use Contao\Widget;

#[AsHook('loadFormField')]
class LoadFormFieldListener
{
    public function __invoke(Widget $widget, string $formId, array $formData, Form $form): Widget
    {
        $advancedCss = trim((string) $widget->advancedCss);

        if (!$form->ac_set || '' === $advancedCss) {
            return $widget;
        }

        // The fieldset template does not output the prefix, only the class
        if ($widget instanceof FormFieldsetStart) {
            $widget->class = trim($widget->class.' '.$advancedCss);
        } else {
            $widget->prefix .= ' '.$advancedCss;
        }

        return $widget;
    }
}
