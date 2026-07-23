<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_globalrandom
 * @copyright   Copyright (C) 2026 Andreas S.
 * @license     GNU Affero General Public License version 3 or later
 */

namespace GR\Component\Globalrandom\Administrator\View\Globalrandom;

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

class HtmlView extends BaseHtmlView
{
    public function display($tpl = null)
    {
        ToolbarHelper::title(Text::_('COM_GLOBALRANDOM'), 'globe');

        parent::display($tpl);
    }
}
