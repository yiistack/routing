<?php

declare(strict_types=1);

namespace Yiistack\Routing;

use Doctrine\Common\Annotations\AnnotationRegistry;
use ReflectionClass;
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

    public function compile(): array
    {
        // autoload
        AnnotationRegistry::registerUniqueLoader('class_exists');

        $compiledRoutes = [];
        $controllers = $this->loader->findClasses(Controller::class);
        $actions = $this->loader->findMethods(Action::class);
        foreach ($controllers as $annotatedClass) {
            $controllerClass = $annotatedClass->getClass();
            $controller = $annotatedClass->getAnnotation();
            $controllerActions = $this->findControllerActions($controllerClass, $actions);
            $compiledRoutes[] = Group::create(
                $controller->getRoute(),
                static function (Group $group) use ($controllerActions) {
                    foreach ($controllerActions as $controllerAction) {
                        $group->addRoute(
                            Route::methods(
                                $controllerAction->getAnnotation()->getMethods(),
                                $controllerAction->getAnnotation()->getRoute(),
                                [
                                    $controllerAction->getClass()->getName(),
                                    $controllerAction->getMethod()->getShortName()
                                ]
                            )
                        );
                    }
                }
            );
        }
        return $compiledRoutes;
    }

    /**
     * @param ReflectionClass $controller
     * @param AnnotatedMethod[] $actions
     * @return iterable|AnnotatedMethod[]
     */
    private function findControllerActions(ReflectionClass $controller, iterable $actions): iterable
    {
        foreach ($actions as $action) {
            if ($action->getClass()->getName() === $controller->getName()) {
                yield $action;
            }
        }
    }
}
