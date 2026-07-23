<?php

/**
 * Raw passthrough of the unmodified global-random.html (and its two
 * description pages), served same-origin so they can sit in the wrapper
 * iframe (see View\Random). Selected via an allow-listed &doc= parameter —
 * never build a path from user input directly. Each doc gets its own
 * Content-Security-Policy, scoped to what that specific file actually
 * needs; the domain lists were confirmed by grepping the files for their
 * real fetch()/script targets and re-checked against a real browser
 * console on crazy-midi.de, not guessed from memory (see the Nextcloud
 * spin-off's CSP list, which was memory-based and turned out incomplete).
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

class RawView extends BaseHtmlView
{
    // embed-cdn.spotifycdn.com and 'unsafe-eval' added 23.07.2026 after a
    // real console check against crazy-midi.de: Spotify's iframe-api
    // script loads a follow-up bundle from there at runtime (not
    // sdk.scdn.co alone, as assumed from the Nextcloud spin-off's
    // unverified CSP list) and that bundle evaluates a string as script
    // during its own init — fails on page load, before any PLAY click, so
    // 'unsafe-eval' is load-bearing here, not a guess.
    private const CSP_APP = "default-src 'self'; "
        . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://open.spotify.com https://sdk.scdn.co "
        . "https://embed-cdn.spotifycdn.com https://cdn.jsdelivr.net; "
        . "style-src 'self' 'unsafe-inline'; "
        . "img-src 'self' data: blob: https://cdn.jsdelivr.net; "
        . "font-src 'self' data:; "
        . "media-src 'self' data: blob:; "
        . "connect-src 'self' https://musicbrainz.org https://api.mymemory.translated.net "
        . "https://open.spotify.com https://api.spotify.com https://sdk.scdn.co "
        . "https://embed-cdn.spotifycdn.com https://*.wikipedia.org https://www.wikidata.org "
        . "https://query.wikidata.org https://api.open-meteo.com; "
        . "frame-src https://open.spotify.com; "
        . "object-src 'none'; base-uri 'self'; form-action 'self'";

    // Description pages are static text + an inline boot-sequence script,
    // no fetch()/XHR at all — only external need is Google Fonts (grepped:
    // fonts.googleapis.com import, so fonts.gstatic.com for the actual
    // woff2 files too).
    private const CSP_DOC = "default-src 'self'; "
        . "script-src 'self' 'unsafe-inline'; "
        . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
        . "font-src 'self' https://fonts.gstatic.com data:; "
        . "img-src 'self' data:; "
        . "object-src 'none'; base-uri 'self'; form-action 'self'";

    private const DOCS = [
        'app' => ['file' => 'global-random.html', 'csp' => self::CSP_APP],
        'de' => ['file' => 'beschreibung.html', 'csp' => self::CSP_DOC],
        'en' => ['file' => 'description.html', 'csp' => self::CSP_DOC],
    ];

    public function display($tpl = null)
    {
        $app = Factory::getApplication();
        $doc = $app->getInput()->getCmd('doc', 'app');
        $entry = self::DOCS[$doc] ?? self::DOCS['app'];

        $app->setHeader('Content-Security-Policy', $entry['csp'], true);
        $app->setHeader('X-Content-Type-Options', 'nosniff', true);

        $path = JPATH_ROOT . '/components/com_globalrandom/' . $entry['file'];

        echo file_get_contents($path);
    }
}
