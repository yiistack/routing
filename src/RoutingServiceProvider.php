<?php

declare(strict_types=1);

namespace Yiistack\Routing;

use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Di\Container;
use Yiisoft\Di\Support\ServiceProvider;
use Yiistack\Annotated\AnnotationLoader;

class RoutingServiceProvider extends ServiceProvider
{
    private array $controllersPaths;

    public function __construct(array $paths = [])
    {
        $this->controllersPaths = $paths;
    }

    /**
     * @suppress PhanAccessMethodProtected
     */
    public function register(Container $container): void
    {
        $aliases = $container->get(Aliases::class);
        $paths = array_map(fn($path) => $aliases->get($path), $this->controllersPaths);
        $finder = (new Finder())->files()->in($paths)->name('*.php');
        $container->set(AnnotationLoader::class, new AnnotationLoader(new ClassLocator($finder)));
    }
}
