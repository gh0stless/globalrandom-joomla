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

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;

return new class implements InstallerScriptInterface {
    private const SUPPORTED_MAJOR = 6;

    public function preflight(string $type, InstallerAdapter $parent): bool
    {
        $major = (int) explode('.', JVERSION)[0];

        if ($major !== self::SUPPORTED_MAJOR) {
            Factory::getApplication()->enqueueMessage(
                Text::sprintf(
                    'COM_GLOBALRANDOM_INSTALL_WRONG_JOOMLA_VERSION',
                    self::SUPPORTED_MAJOR,
                    JVERSION
                ),
                'error'
            );

            return false;
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
        return true;
    }
};
