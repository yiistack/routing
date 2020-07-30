<?php

declare(strict_types=1);

namespace Yiistack\Routing\Annotation;

abstract class Action
{
    abstract public function getMethods(): array;
}
