<?php

declare(strict_types=1);

namespace Yiistack\Routing;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Yiistack\Annotated\AnnotationLoader;
use Yiistack\Routing\Annotation\Controller;
use Yiistack\Routing\Annotation\RouteAnnotationInterface;

class RouteCompiler
{
    private AnnotationLoader $loader;

    public function __construct(AnnotationLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @psalm-suppress DeprecatedMethod
     *
     * @return array
     */
    public function compile(): array
    {
        // autoload
        AnnotationRegistry::registerUniqueLoader('class_exists');

        $compiledRoutes = [];
        $controllers = $this->loader->findClasses(Controller::class);
        foreach ($controllers as $annotatedClass) {
            $controllerClass = $annotatedClass->getClass();
            $controller = $annotatedClass->getAnnotation();
            $controllerRoutes = $this->loader->findMethods(RouteAnnotationInterface::class, $controllerClass);
            $compiledRoutes[] = Group::create(
                $controller->getRoute(),
                static function (Group $group) use ($controllerRoutes) {
                    foreach ($controllerRoutes as $controllerAction) {
                        $group->addRoute(
                            Route::methods(
                                $controllerAction->getAnnotation()->getMethods(),
                                $controllerAction->getAnnotation()->getRoute(),
                                [
                                    $controllerAction->getClass()->getName(),
                                    $controllerAction->getMethod()->getShortName(),
                                ]
                            )
                        );
                    }
                }
            );
        }

        return $compiledRoutes;
    }
}
