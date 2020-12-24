<?php

declare(strict_types=1);

namespace Yiistack\Routing\Annotation;

/**
 * Class Route
 * @package Yiistack\Routing\Annotation
 */
abstract class Route implements RouteAnnotationInterface
{
    /**
     * @var mixed|string
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected string $route;

    /**
     * @var array
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected array $methods;

    /**
     * @var array
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected array $middlewares;

    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->route = $values['value'];
        }
        if (isset($values['middlewares'])) {
            $this->middlewares = $values['middlewares'];
        }
        if (isset($values['methods'])) {
            $this->methods = $values['methods'];
        }
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
