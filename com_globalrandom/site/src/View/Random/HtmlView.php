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
    public $playerUrl;

    public function display($tpl = null)
    {
        $this->playerUrl = Route::_('index.php?option=com_globalrandom&view=player&format=raw', false);

        $document = $this->getDocument();
        $document->setTitle(Text::_('COM_GLOBALRANDOM_PAGE_TITLE'));
        $document->getWebAssetManager()->registerAndUseStyle(
            'com_globalrandom.style',
            'media/com_globalrandom/css/style.css'
        );

        parent::display($tpl);
    }
}
