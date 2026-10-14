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

namespace ContaoDD\AdvancedClassesBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;

#[AsCallback(table: 'tl_page', target: 'fields.ac_set.options')]
#[AsCallback(table: 'tl_form', target: 'fields.ac_set.options')]
class AcSetListener
{
    use ListenerHelperTrait;

    private const BUNDLE_PUBLIC_PATH = 'bundles/contaoddadvancedclasses/';

    public function __construct(
        private readonly string $projectDir,
        private readonly string $webDir,
    ) {
    }

    /**
     * Returns the available sets as path => title.
     */
    public function __invoke(): array
    {
        $sets = $this->sets;

        // add custom sets
        if (isset($GLOBALS['customAdvancedClassesSets']) && \is_array($GLOBALS['customAdvancedClassesSets'])) {
            $sets = array_values(array_unique(array_merge($sets, $GLOBALS['customAdvancedClassesSets'])));
        }

        $options = [];

        foreach ($sets as $path) {
            $options[$path] = $this->getTitle($path);
        }

        return $options;
    }

    private function getTitle(string $path): string
    {
        $relativePath = ltrim($path, '/');
        $candidates = [];

        if (str_starts_with($relativePath, self::BUNDLE_PUBLIC_PATH)) {
            $candidates[] = \dirname(__DIR__, 3).'/public/'.substr($relativePath, \strlen(self::BUNDLE_PUBLIC_PATH));
        }

        $candidates[] = $this->webDir.'/'.$relativePath;
        $candidates[] = $this->projectDir.'/'.$relativePath;

        foreach ($candidates as $file) {
            if (!is_file($file)) {
                continue;
            }

            try {
                $title = json_decode((string) file_get_contents($file), true, 512, JSON_THROW_ON_ERROR)['title'] ?? null;
            } catch (\JsonException) {
                $title = null;
            }

            if (\is_string($title) && '' !== trim($title)) {
                return trim($title);
            }

            break;
        }

        // Fall back to the file name if the set cannot be read or has no title
        return basename($path);
    }
}
