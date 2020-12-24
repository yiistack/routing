<?php

declare(strict_types=1);

namespace Yiistack\Routing\Annotation;

interface RouteAnnotationInterface
{
    public function getRoute(): string;

    public function getMethods(): array;

    public function getMiddlewares(): array;
}