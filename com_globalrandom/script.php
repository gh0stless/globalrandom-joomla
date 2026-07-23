<?php

/**
 * Install/update guard for com_globalrandom.
 *
 * Andreas' explicit preference from the sibling Nextcloud project
 * (globalrandom app, jsidplay2 app): pin tightly to the Joomla major
 * version this was actually built/tested against and fail loudly on
 * install rather than risk a silent breakage on an unsupported major.
 *
 * @package     Joomla.Site
 * @subpackage  com_globalrandom
 * @copyright   Copyright (C) 2026 Andreas S.
 * @license     GNU Affero General Public License version 3 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;

return new class implements InstallerScriptInterface {
    private const SUPPORTED_MAJOR = 6;

    public function preflight(string $type, InstallerAdapter $parent): bool
    {
        // Deliberately not Text::_()/Text::sprintf(): on a fresh install
        // this runs before com_globalrandom's own language files are
        // registered, so a language key would render as the raw,
        // untranslated key string instead of a message. Hardcoded string
        // + exception is the documented reliable way to abort a Joomla
        // install from preflight().
        $major = (int) explode('.', JVERSION)[0];

        if ($major !== self::SUPPORTED_MAJOR) {
            throw new \RuntimeException(sprintf(
                'com_globalrandom was built and tested for Joomla %d.x only '
                . '— this site is running %s. Installation stopped to avoid '
                . 'a silent break; re-check compatibility before forcing an install.',
                self::SUPPORTED_MAJOR,
                JVERSION
            ));
        }

        return true;
    }

    public function install(InstallerAdapter $parent): bool
    {
        return true;
    }

    public function update(InstallerAdapter $parent): bool
    {
        return true;
    }

    public function uninstall(InstallerAdapter $parent): bool
    {
        return true;
    }

    public function postflight(string $type, InstallerAdapter $parent): bool
    {
        // One-off cleanup: a 23.07.2026 update briefly shipped an
        // App/Beschreibung/Description nav feature that was reverted the
        // same day (unwanted — the description pages are already reachable
        // via the main site, and the extra buttons just took up space).
        // Joomla's installer only ever copies/overwrites what the current
        // manifest lists; it never deletes files a PREVIOUS version
        // installed that the new manifest no longer mentions. So the
        // reverted files ended up orphaned on disk. Joomla's own installer
        // process is used to remove them here instead of asking for fresh
        // FTP/SSH credentials for a one-off manual delete.
        if ($type === 'update') {
            $orphaned = [
                JPATH_ROOT . '/components/com_globalrandom/beschreibung.html',
                JPATH_ROOT . '/components/com_globalrandom/description.html',
                JPATH_ROOT . '/media/com_globalrandom/js/nav.js',
            ];

            foreach ($orphaned as $path) {
                if (is_file($path)) {
                    @unlink($path);
                }
            }
        }

        return true;
    }
};
