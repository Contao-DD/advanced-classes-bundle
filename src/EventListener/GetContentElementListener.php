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

use Contao\ContentModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;

#[AsHook('getContentElement')]
class GetContentElementListener
{
    /*
     * add advanced css to the class attribute of the element's outermost tag
     */
    public function __invoke(ContentModel $contentModel, string $buffer, $element): string
    {
        $advancedCss = preg_split('/\s+/', (string) $contentModel->advancedCss, -1, PREG_SPLIT_NO_EMPTY);

        if (!$advancedCss) {
            return $buffer;
        }

        return preg_replace_callback(
            '/class="([^"]*)"/',
            static function (array $matches) use ($advancedCss): string {
                $existing = preg_split('/\s+/', $matches[1], -1, PREG_SPLIT_NO_EMPTY);
                $missing = array_diff($advancedCss, $existing);

                if (!$missing) {
                    return $matches[0];
                }

                return 'class="'.implode(' ', [...$missing, ...$existing]).'"';
            },
            $buffer,
            1,
        );
    }
}
