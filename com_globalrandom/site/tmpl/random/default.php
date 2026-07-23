<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_globalrandom
 * @copyright   Copyright (C) 2026 Andreas S.
 * @license     GNU Affero General Public License version 3 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/** @var \GR\Component\Globalrandom\Site\View\Random\HtmlView $this */
?>
<div id="globalrandom-wrapper"
     class="globalrandom-wrap"
     data-app-src="<?php echo htmlspecialchars($this->appSrc, ENT_QUOTES, 'UTF-8'); ?>"
     data-de-src="<?php echo htmlspecialchars($this->deSrc, ENT_QUOTES, 'UTF-8'); ?>"
     data-en-src="<?php echo htmlspecialchars($this->enSrc, ENT_QUOTES, 'UTF-8'); ?>">
    <div class="globalrandom-nav">
        <button type="button" class="globalrandom-nav-btn active" data-target="app">GLOBAL RANDOM</button>
        <button type="button" class="globalrandom-nav-btn" data-target="de"><?php echo Text::_('COM_GLOBALRANDOM_NAV_DE'); ?></button>
        <button type="button" class="globalrandom-nav-btn" data-target="en"><?php echo Text::_('COM_GLOBALRANDOM_NAV_EN'); ?></button>
    </div>
    <iframe
        id="globalrandom-frame"
        src="<?php echo htmlspecialchars($this->appSrc, ENT_QUOTES, 'UTF-8'); ?>"
        title="GLOBAL RANDOM — Democracy of Sound"
        allow="autoplay; fullscreen"
        loading="lazy"
    ></iframe>
</div>
