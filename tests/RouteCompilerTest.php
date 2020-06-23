<?php

namespace Yiistack\Routing\Tests;

use PHPUnit\Framework\TestCase;
use Yiistack\Routing\RouteCompiler;

class RouteCompilerTest extends TestCase
{
    public function testCompile()
    {
        $rc = new RouteCompiler([__DIR__ . '/Data']);

        $routes = $rc->compile();

        var_dump($routes);
    }
}
