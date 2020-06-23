<?php

declare(strict_types=1);

namespace Yiistack\Routing;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;
use Yiistack\Routing\Annotation\Controller;

class RouteCompiler
{
    private array $controllerPath;
    private AnnotationReader $reader;

    public function __construct(array $controllerPath = [])
    {
        $this->reader = new AnnotationReader();
        $this->controllerPath = $controllerPath;
    }

    public function compile()
    {
        // autoload
        AnnotationRegistry::registerUniqueLoader('class_exists');

        $compiledRoutes = [];
        foreach ($this->getClassLocator()->getClasses() as $class) {
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

    private function getClassLocator()
    {
        $finder = (new Finder())->files()->in($this->controllerPath)->name('*.php');

        return new ClassLocator($finder);
    }


}
