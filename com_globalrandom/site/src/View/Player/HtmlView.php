<?php

/**
 * Raw passthrough of the unmodified global-random.html, served same-origin
 * so it can sit in the wrapper iframe (see View\Random). This view sets its
 * own Content-Security-Policy, scoped to exactly the third-party domains
 * GLOBAL RANDOM itself calls out to (Spotify embed/oEmbed, MusicBrainz,
 * Wikipedia/Wikidata, MyMemory, Open-Meteo, jsDelivr/Twemoji) — confirmed
 * by grepping global-random.html for its actual fetch()/script targets,
 * not guessed. Still worth re-checking in the browser console against the
 * real crazy-midi.de deployment (CSP violations show up there explicitly)
 * before calling this final, same lesson learned on the Nextcloud spin-off.
 *
 * @package     Joomla.Site
 * @subpackage  com_globalrandom
 * @copyright   Copyright (C) 2026 Andreas S.
 * @license     GNU Affero General Public License version 3 or later
 */

namespace GR\Component\Globalrandom\Site\View\Player;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

class HtmlView extends BaseHtmlView
{
    private const CSP = "default-src 'self'; "
        . "script-src 'self' 'unsafe-inline' https://open.spotify.com https://sdk.scdn.co https://cdn.jsdelivr.net; "
        . "style-src 'self' 'unsafe-inline'; "
        . "img-src 'self' data: blob: https://cdn.jsdelivr.net; "
        . "font-src 'self' data:; "
        . "media-src 'self' data: blob:; "
        . "connect-src 'self' https://musicbrainz.org https://api.mymemory.translated.net "
        . "https://open.spotify.com https://api.spotify.com https://sdk.scdn.co "
        . "https://*.wikipedia.org https://www.wikidata.org https://query.wikidata.org "
        . "https://api.open-meteo.com; "
        . "frame-src https://open.spotify.com; "
        . "object-src 'none'; base-uri 'self'; form-action 'self'";

    public function display($tpl = null)
    {
        $app = Factory::getApplication();
        $app->setHeader('Content-Security-Policy', self::CSP, true);
        $app->setHeader('X-Content-Type-Options', 'nosniff', true);

        $path = JPATH_ROOT . '/components/com_globalrandom/global-random.html';

        echo file_get_contents($path);
    }
}
