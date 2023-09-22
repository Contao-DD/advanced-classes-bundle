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

namespace ContaoDD\AdvancedClassesBundle\EventListener\DataContainer;

use Contao\ArticleModel;
use Contao\DataContainer;
use Contao\FormModel;
use Contao\PageModel;

trait ListenerHelperTrait
{
    public array $sets = [
        'bundles/contaoddadvancedclasses/sets/bootstrap2.json',
        'bundles/contaoddadvancedclasses/sets/bootstrap3.json',
        'bundles/contaoddadvancedclasses/sets/bootstrap4-alpha.json',
        'bundles/contaoddadvancedclasses/sets/bootstrap4.json',
        'bundles/contaoddadvancedclasses/sets/materialize.json',
        'bundles/contaoddadvancedclasses/sets/bulma.json',
        'bundles/contaoddadvancedclasses/sets/spectre.json',
    ];

    public function generateScriptTag($config): string
    {
        if(false === $config[2]) {
            $GLOBALS['TL_CSS']['advanced_classes'] = 'bundles/contaoddadvancedclasses/css/advanced_classes.css|static';
            $GLOBALS['TL_CSS']['font-awesome'] = 'bundles/contaoddadvancedclasses/vendor/fontello/css/icon.css|static';
        }
        $GLOBALS['TL_CSS']['advanced_classes_settings'] = 'bundles/contaoddadvancedclasses/css/advanced_classes_settings.css|static';
        
        return sprintf(
            '<script>var advancedClassesSet = \'%s\';var defaultColumnWidth = \'%s\';</script>',
            $config[0],
            $config[1]
        );
    }

    public function getConfigOfRootPageByContentElementId($id): ?array
    {
        $rootPage = $this->findRootPageOfContentElement($id);

        if (null === $rootPage) {
            return null;
        }

        return $this->getConfig($rootPage);
    }

    public function findRootPageOfContentElement($id): ?PageModel
    {
        // get pid of article
        $article = ArticleModel::findById($id);

        if (null === $article) {
            return null;
        }

        $parentPage = PageModel::findParentsById($article->pid);

        if (null === $parentPage) {
            return null;
        }

        return $parentPage[\count($parentPage) - 1];
    }

    public function getConfigOfFormId($id): ?array
    {
        $form = FormModel::findById($id);

        if (null === $form) {
            return null;
        }

        return $this->getConfig($form);
    }

    public function getConfig($model): array
    {
        return [
            $model->ac_set,
            $model->ac_defaultColumnWidth,
            $model->ac_disableCSS,
        ];
    }

    private function manipulateDca(DataContainer $dc, $field): void
    {
        if (!$dc->id || 'edit' !== $this->requestStack->getCurrentRequest()->query->get('act')) {
            return;
        }

        $dc = &$GLOBALS['TL_DCA'][$dc->table];

        foreach ($dc['palettes'] as $key => $value) {
            if ('__selector__' === $value) {
                continue;
            }

            if (!\is_array($value) && str_contains($value, $field)) {
                $dc['palettes'][$key] = str_replace($field, $field.';{advanced_classes_legend},advancedCss;', $value);
            }
        }
    }
}
