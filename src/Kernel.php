<?php

namespace App;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Kernel extends BaseKernel
{
    public function registerBundles(): iterable
    {
        $contents = require dirname(__DIR__).'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    public function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $confDir = dirname(__DIR__).'/config';

        $loader->load($confDir.'/packages/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/packages/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/services'.self::CONFIG_EXTS, 'glob');
        $loader->load($confDir.'/services_'.$this->environment.self::CONFIG_EXTS, 'glob');
    }

    public function configureRoutes($routes): void
    {
        $confDir = dirname(__DIR__).'/config';

        $routes->import($confDir.'/routes/*'.self::CONFIG_EXTS, 'glob');
        $routes->import($confDir.'/routes/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
        $routes->import($confDir.'/routes'.self::CONFIG_EXTS, 'glob');
    }
}
