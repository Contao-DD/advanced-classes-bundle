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

use Contao\ArticleModel;
use Contao\CalendarEventsModel;
use Contao\CalendarModel;
use Contao\ContentModel;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\DataContainer;
use Contao\FormModel;
use Contao\Model;
use Contao\NewsArchiveModel;
use Contao\NewsModel;
use Contao\PageModel;

trait ListenerHelperTrait
{
    public array $sets = [
        'bundles/contaoddadvancedclasses/sets/bootstrap4.json',
        'bundles/contaoddadvancedclasses/sets/bootstrap5.json',
        'bundles/contaoddadvancedclasses/sets/materialize.json',
        'bundles/contaoddadvancedclasses/sets/bulma.json',
        'bundles/contaoddadvancedclasses/sets/spectre.json',
    ];

    public function generateScriptTag($config): string
    {
        if (null === $config) {
            return '<span style="font-size:.8em;color:red;">&nbsp;🛈&nbsp;'.$GLOBALS['TL_LANG']['tl_content']['advancedCss']['noConfigMessage'].'</span>';
        }

        if (!$config[2]) {
            $GLOBALS['TL_CSS']['advanced_classes'] = 'bundles/contaoddadvancedclasses/css/advanced_classes.css|static';
            $GLOBALS['TL_CSS']['font-awesome'] = 'bundles/contaoddadvancedclasses/vendor/fontello/css/icon.css|static';
        }
        $GLOBALS['TL_CSS']['advanced_classes_settings'] = 'bundles/contaoddadvancedclasses/css/advanced_classes_settings.css|static';

        return \sprintf(
            '<span hidden data-advanced-classes-set="%s" data-advanced-classes-default-column-width="%s"></span>',
            htmlspecialchars((string) $config[0], ENT_QUOTES),
            $config[1] ? '1' : '0',
        );
    }

    /**
     * Returns the config of the root page the given content element belongs to.
     */
    public function getConfigOfContentElement(array|null $record): array|null
    {
        // Resolve nested elements (e.g. element groups) to the top level element
        $depth = 0;

        while (null !== $record && 'tl_content' === ($record['ptable'] ?? null) && $depth++ < 50) {
            $record = ContentModel::findById($record['pid'])?->row();
        }

        if (null === $record) {
            return null;
        }

        $pageId = match ($record['ptable'] ?? '' ?: 'tl_article') {
            'tl_article' => ArticleModel::findById($record['pid'])?->pid,
            'tl_news' => $this->getJumpToOfNews((int) $record['pid']),
            'tl_calendar_events' => $this->getJumpToOfEvent((int) $record['pid']),
            default => null,
        };

        return $this->getConfig($this->findRootPage($pageId ? (int) $pageId : null));
    }

    public function findRootPage(int|null $pageId): PageModel|null
    {
        if (!$pageId) {
            return null;
        }

        $parentPages = PageModel::findParentsById($pageId);

        if (null === $parentPages) {
            return null;
        }

        // The last parent is the root page
        $models = $parentPages->getModels();

        return end($models) ?: null;
    }

    public function getConfigOfFormId($id): array|null
    {
        return $this->getConfig(FormModel::findById($id));
    }

    public function getConfig(Model|null $model): array|null
    {
        if (null === $model || !$model->ac_set) {
            return null;
        }

        return [
            $model->ac_set,
            $model->ac_defaultColumnWidth,
            $model->ac_disableCSS,
        ];
    }

    private function getJumpToOfNews(int $newsId): int|null
    {
        if (!class_exists(NewsModel::class)) {
            return null;
        }

        $archiveId = NewsModel::findById($newsId)?->pid;
        $jumpTo = $archiveId ? NewsArchiveModel::findById($archiveId)?->jumpTo : null;

        return $jumpTo ? (int) $jumpTo : null;
    }

    private function getJumpToOfEvent(int $eventId): int|null
    {
        if (!class_exists(CalendarEventsModel::class)) {
            return null;
        }

        $calendarId = CalendarEventsModel::findById($eventId)?->pid;
        $jumpTo = $calendarId ? CalendarModel::findById($calendarId)?->jumpTo : null;

        return $jumpTo ? (int) $jumpTo : null;
    }

    /**
     * Adds the advanced classes legend after the expert legend of every palette that
     * contains the given CSS field (e.g. "cssID" or "class").
     */
    private function manipulateDca(DataContainer $dc, string $cssField): void
    {
        $act = $this->requestStack->getCurrentRequest()?->query->get('act');

        if (!$dc->id || !\in_array($act, ['edit', 'editAll'], true)) {
            return;
        }

        $manipulator = PaletteManipulator::create()
            ->addLegend('advanced_classes_legend', 'expert_legend')
            ->addField('advancedCss', 'advanced_classes_legend', PaletteManipulator::POSITION_APPEND)
        ;

        foreach ($GLOBALS['TL_DCA'][$dc->table]['palettes'] ?? [] as $name => $palette) {
            if ('__selector__' === $name || !\is_string($palette)) {
                continue;
            }

            if ($this->paletteHasField($palette, $cssField) && !$this->paletteHasField($palette, 'advancedCss')) {
                $manipulator->applyToPalette($name, $dc->table);
            }
        }
    }

    private function paletteHasField(string $palette, string $field): bool
    {
        // Remove the legends and compare the field names
        $fields = preg_split('/[,;]/', preg_replace('/\{[^}]*\}/', '', $palette), -1, PREG_SPLIT_NO_EMPTY);

        return \in_array($field, array_map('trim', $fields), true);
    }
}
