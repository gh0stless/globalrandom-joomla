<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_globalrandom
 * @copyright   Copyright (C) 2026 Andreas S.
 * @license     GNU Affero General Public License version 3 or later
 */

namespace GR\Component\Globalrandom\Site\View\Random;

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Router\Route;

class HtmlView extends BaseHtmlView
{
    /** @var string */
    public $appSrc;

    /** @var string */
    public $deSrc;

    /** @var string */
    public $enSrc;

    public function display($tpl = null)
    {
        $this->appSrc = Route::_('index.php?option=com_globalrandom&view=player&format=raw&doc=app', false);
        $this->deSrc = Route::_('index.php?option=com_globalrandom&view=player&format=raw&doc=de', false);
        $this->enSrc = Route::_('index.php?option=com_globalrandom&view=player&format=raw&doc=en', false);

        $document = $this->getDocument();
        $document->setTitle(Text::_('COM_GLOBALRANDOM_PAGE_TITLE'));
        $document->getWebAssetManager()->registerAndUseStyle(
            'com_globalrandom.style',
            'media/com_globalrandom/css/style.css'
        );
        $document->getWebAssetManager()->registerAndUseScript(
            'com_globalrandom.nav',
            'media/com_globalrandom/js/nav.js'
        );

        parent::display($tpl);
    }
}
