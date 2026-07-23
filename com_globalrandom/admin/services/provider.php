<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_globalrandom
 * @copyright   Copyright (C) 2026 Andreas S.
 * @license     GNU Affero General Public License version 3 or later
 */

defined('_JEXEC') or die;

use GR\Component\Globalrandom\Administrator\Extension\GlobalrandomComponent;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class implements ServiceProviderInterface {
    public function register(Container $container): void
    {
        $namespace = '\\GR\\Component\\Globalrandom';

        $container->registerServiceProvider(new ComponentDispatcherFactory($namespace));
        $container->registerServiceProvider(new MVCFactory($namespace));

        $container->set(
            ComponentInterface::class,
            function (Container $container) {
                $component = new GlobalrandomComponent(
                    $container->get(ComponentDispatcherFactoryInterface::class)
                );
                $component->setMVCFactory($container->get(MVCFactoryInterface::class));

                return $component;
            }
        );
    }
};
