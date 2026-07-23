<?php

/**
 * @package     Joomla.Site
 * @subpackage  com_globalrandom
 * @copyright   Copyright (C) 2026 Andreas S.
 * @license     GNU Affero General Public License version 3 or later
 */

defined('_JEXEC') or die;

/** @var \GR\Component\Globalrandom\Site\View\Random\HtmlView $this */
?>
<div class="globalrandom-wrap">
    <iframe
        src="<?php echo htmlspecialchars($this->playerUrl, ENT_QUOTES, 'UTF-8'); ?>"
        title="GLOBAL RANDOM — Democracy of Sound"
        allow="autoplay; fullscreen"
        loading="lazy"
    ></iframe>
</div>
