<?php

declare(strict_types=1);

use Yiistack\Routing\RoutingServiceProvider;

if ((bool)$params['yiistack/routing']['enabled'] !== true) {
    return [];
}

return [
    'yiistack/routing' => [
        '__class' => RoutingServiceProvider::class,
        '__construct()' => [(array)$params['yiistack/routing']['controllersPaths']]
    ]
];
