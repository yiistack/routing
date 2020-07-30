<?php

namespace Yiistack\Routing\Tests;

use PHPUnit\Framework\TestCase;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;
use Yiistack\Annotated\AnnotationLoader;
use Yiistack\Routing\RouteCompiler;

class RouteCompilerTest extends TestCase
{
    public function testCompile()
    {
        $finder = Finder::create()->in([__DIR__ . '/Data'])->name('*.php');
        $rc = new RouteCompiler(new AnnotationLoader(new ClassLocator($finder)));

        $routes = $rc->compile();

        var_dump($routes);
    }
}
