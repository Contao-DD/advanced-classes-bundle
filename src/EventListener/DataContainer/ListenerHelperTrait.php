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
use Contao\CalendarEventsModel;
use Contao\CalendarModel;
use Contao\ContentModel;
use Contao\DataContainer;
use Contao\FormModel;
use Contao\Model;
use Contao\NewsArchiveModel;
use Contao\NewsModel;
use Contao\PageModel;

trait ListenerHelperTrait
{
    public array $sets = [
        'bundles/contaoddadvancedclasses/sets/bootstrap2.json',
        'bundles/contaoddadvancedclasses/sets/bootstrap3.json',
        'bundles/contaoddadvancedclasses/sets/bootstrap4-alpha.json',
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
        
        return sprintf(
            '<span hidden data-advanced-classes-set="%s" data-advanced-classes-default-column-width="%s"></span>',
            htmlspecialchars((string) $config[0], ENT_QUOTES),
            $config[1] ? '1' : '0'
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

        $pageId = match (($record['ptable'] ?? '') ?: 'tl_article') {
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
        return $parentPages->last();
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

        return $archiveId ? NewsArchiveModel::findById($archiveId)?->jumpTo : null;
    }

    private function getJumpToOfEvent(int $eventId): int|null
    {
        if (!class_exists(CalendarEventsModel::class)) {
            return null;
        }

        $calendarId = CalendarEventsModel::findById($eventId)?->pid;

        return $calendarId ? CalendarModel::findById($calendarId)?->jumpTo : null;
    }

    private function manipulateDca(DataContainer $dc, string $field): void
    {
        $act = $this->requestStack->getCurrentRequest()?->query->get('act');

        if (!$dc->id || !\in_array($act, ['edit', 'editAll'], true)) {
            return;
        }

        $palettes = &$GLOBALS['TL_DCA'][$dc->table]['palettes'];

        foreach ($palettes as $key => $value) {
            if ('__selector__' === $key || !\is_string($value)) {
                continue;
            }

            if (str_contains($value, $field)) {
                $palettes[$key] = str_replace($field, $field.';{advanced_classes_legend},advancedCss;', $value);
            }
        }
    }
}
