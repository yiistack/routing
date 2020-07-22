<?php

declare(strict_types=1);

namespace Yiistack\Routing;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;
use Yiistack\Annotated\AnnotationLoader;
use Yiistack\Routing\Annotation\Action;
use Yiistack\Routing\Annotation\Controller;

class RouteCompiler
{
    private AnnotationReader $reader;
    private AnnotationLoader $loader;

    public function __construct(AnnotationLoader $loader, AnnotationReader $reader = null)
    {
        $this->loader = $loader;
        $this->reader = $reader ?? new AnnotationReader();
    }

    public function compile()
    {
        // autoload
        AnnotationRegistry::registerUniqueLoader('class_exists');

        $compiledRoutes = [];
        foreach ($this->loader->findClasses(Action::class) as $class) {
            /** @var Controller $c */
            $c = $this->reader->getClassAnnotation($class, Controller::class);
            $actions = [];
            foreach ($class->getMethods() as $method) {
                $actions = array_merge($actions, $this->reader->getMethodAnnotations($method));
            }
            $compiledRoutes[] = [
                'c' => $c,
                'a' => $actions
            ];
        }
        return $compiledRoutes;
    }
}
