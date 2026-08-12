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

class RawView extends BaseHtmlView
{
    // embed-cdn.spotifycdn.com added 23.07.2026 after a real console check
    // against crazy-midi.de: Spotify's iframe-api script loads its own
    // follow-up bundle from there at runtime, not from sdk.scdn.co as
    // assumed from the Nextcloud spin-off's (unverified) CSP list. Exactly
    // the kind of gap only a real browser console catches — see class doc.
    // 'unsafe-eval' added 23.07.2026, also after a real console check:
    // Spotify's embed-cdn.spotifycdn.com bundle evaluates a string as
    // script during its own init (fails on page load, before any PLAY
    // click), not just some optional feature. Deliberate deviation from
    // the Nextcloud spin-off's "start tight, don't open eval
    // prophylactically" stance — here there's proof it's load-bearing,
    // not a guess. Still scoped to the same short, explicit script-src
    // allow-list, not opened globally.
    // upload.wikimedia.org added 12.08.2026, reported live: artist-card
    // photos (fetchWiki()'s d.img, e.g. Welle:Erdball's band photo) never
    // rendered on this deployment, only here — the FTP version has no CSP
    // at all, and the Nextcloud one bypasses PHP/CSP entirely for this
    // file, so neither was affected. Wikipedia's page-summary API returns
    // a real, publicly loadable thumbnail URL (verified directly against
    // the API), but the thumbnail file itself lives on a DIFFERENT host
    // than *.wikipedia.org (which was already allow-listed for the article
    // text fetches) - connect-src's *.wikipedia.org entry never covered
    // this img-src gap, an easy thing to miss since it's not obviously the
    // "same domain" despite being the same project.
    private const CSP = "default-src 'self'; "
        . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://open.spotify.com https://sdk.scdn.co "
        . "https://embed-cdn.spotifycdn.com https://cdn.jsdelivr.net; "
        . "style-src 'self' 'unsafe-inline'; "
        . "img-src 'self' data: blob: https://cdn.jsdelivr.net https://upload.wikimedia.org; "
        . "font-src 'self' data:; "
        . "media-src 'self' data: blob:; "
        . "connect-src 'self' https://musicbrainz.org https://api.mymemory.translated.net "
        . "https://open.spotify.com https://api.spotify.com https://sdk.scdn.co "
        . "https://embed-cdn.spotifycdn.com https://*.wikipedia.org https://www.wikidata.org "
        . "https://query.wikidata.org https://api.open-meteo.com; "
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
