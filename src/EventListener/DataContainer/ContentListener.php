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

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\Database;
use Contao\DataContainer;
use Contao\NewsModel;
use Contao\NewsArchiveModel;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\RequestStack;

class ContentListener
{
    use ListenerHelperTrait;

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->database = Database::getInstance();
        $this->requestStack = $requestStack;
    }

    #[AsCallback(table: 'tl_content', target: 'config.onload')]
    public function onLoad(DataContainer $dc = null): void
    {
        $this->manipulateDca($dc, 'cssID;');
        $this->manipulateDca($dc, 'useHomeDir;');
    }

    #[AsCallback(table: 'tl_content', target: 'fields.advancedCss.xlabel')]
    public function onXlabel(DataContainer $dc): string
    {
        $config = null;
        
        if ('tl_news' === $dc->activeRecord->ptable || 'tl_calendar_events' === $dc->activeRecord->ptable) {
            $archiveId = NewsModel::findByPk($dc->activeRecord->pid)->pid;
            $jumpToId = NewsArchiveModel::findByPk($archiveId)->jumpTo;
            $config = $this->getConfig($this->getRootPage($jumpToId));
        }
        
        if (null === $config) {
            $config = $this->getConfigOfRootPageByContentElementId((int) $dc->activeRecord->pid);
        }

        return $this->generateScriptTag($config);
    }

    /**
     * Find the root page
     *
     * @param int $intId
     */
    protected function getRootPage($intId)
    {
        $rootPageId = $this->getParentPage($intId);
        return PageModel::findByPk($rootPageId);
    }

    /**
     * Get parent page
     *
     * @param int $intId
     * @return object DatabaseResult
     */
    protected function getParentPage($intId)
    {
        $objResult = $this->database->prepare("SELECT id, pid, type FROM tl_page WHERE id=?")->execute($intId);

        if ($objResult->pid == 0 || $objResult->type == 'root')
        {
            return $objResult->id;
        }
        else
        {
            return $this->getParentPage($objResult->pid);
        }
    }
}
