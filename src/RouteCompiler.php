<?php

declare(strict_types=1);

namespace Yiistack\Routing;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Yiistack\Annotated\AnnotatedMethod;
use Yiistack\Annotated\AnnotationLoader;
use Yiistack\Routing\Annotation\Action;
use Yiistack\Routing\Annotation\Controller;

class RouteCompiler
{
    private AnnotationLoader $loader;

    public function __construct(AnnotationLoader $loader)
    {
        $this->loader = $loader;
    }

    public function compile()
    {
        // autoload
        AnnotationRegistry::registerUniqueLoader('class_exists');

        $compiledRoutes = [];
        $controllers = $this->loader->findClasses(Controller::class);
        $actions = $this->loader->findMethods(Action::class);
        foreach ($controllers as $annotatedClass) {
            $controller = $annotatedClass->getAnnotation();
            $controllerActions = $this->findControllerActions($annotatedClass->getClass(), $actions);
            $compiledRoutes[] = Group::create(
                $controller->getRoute(),
                static function (Group $group) use ($controller, $controllerActions) {
                    foreach ($controllerActions as $controllerAction) {
                        $group->addRoute(
                            Route::methods(
                                $controllerAction->getMethods(),
                                $controllerAction->getRoute(),
                                [$controller->getClass()->getName(), $controllerAction->getMethod()->getName()]
                            )
                        );
                    }
                }
            );
        }
        return $compiledRoutes;
    }

    /**
     * @param $controller
     * @param $actions
     * @return iterable|AnnotatedMethod[]
     */
    private function findControllerActions($controller, $actions): iterable
    {
        foreach ($actions as $action) {
            if ($action->getClass()->getName() === $controller) {
                yield $action;
            }
        }
    }
}
