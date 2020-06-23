<?php

declare(strict_types=1);

namespace Yiistack\Routing\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Controller
{
    private string $route;
    private array $middlewares;
    private array $actions = [];

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

    public function addActions(array $actions)
    {
        $this->actions = array_merge($this->actions, $actions);
    }
}
