<?php

declare(strict_types=1);

namespace Yiistack\Routing\Annotation;


class Action
{
    protected array $methods;

    public function getMethods(): array
    {
        return $this->methods;
    }
}
