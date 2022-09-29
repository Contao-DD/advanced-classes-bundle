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

namespace ContaoDD\AdvancedClassesBundle\EventListener;

use Contao\ContentModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;

#[AsHook('getContentElement')]
class GetContentElementListener
{
    /*
     * manipulate the given template object to add advanced css to the existing css class
     */
    public function __invoke(ContentModel $contentModel, string $buffer, $element): string
    {
        if (isset($contentModel->advancedCss) && '' !== $contentModel->advancedCss) {
            return preg_replace("/class=\"/",'class="' . $contentModel->advancedCss . ' ',$buffer,1);
        }

        return $buffer;
    }
}
