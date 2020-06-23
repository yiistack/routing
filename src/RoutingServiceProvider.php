<?php


namespace Yiistack\Routing;


use Symfony\Component\Finder\Finder;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Di\Container;
use Yiisoft\Di\Support\ServiceProvider;

class RoutingServiceProvider extends ServiceProvider
{
    private array $controllersPath = [];

    public function __construct(array $paths)
    {
        $this->controllersPath = $paths;
    }

    public function register(Container $container): void
    {
        $aliases = $container->get(Aliases::class);
        $paths = array_map(fn($path) => $aliases->get($path), $this->controllersPath);
        $finder = (new Finder())->files()->in($paths)->name('*.php');
    }
}
