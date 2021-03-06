<?php

declare(strict_types=1);

namespace Yiistack\Routing\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class Controller
{
    /**
     * @var mixed|string
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private string $route;

    /**
     * @var array
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private array $middlewares;

    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->route = $values['value'];
        }
        if (isset($values['middlewares'])) {
            $this->middlewares = $values['middlewares'];
        }
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
