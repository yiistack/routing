<?php

declare(strict_types=1);

namespace Yiistack\Routing\Tests;

use PHPUnit\Framework\TestCase;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;
use Yiisoft\Router\Group;
use Yiisoft\VarDumper\VarDumper;
use Yiistack\Annotated\AnnotationLoader;
use Yiistack\Routing\RouteCompiler;

class RouteCompilerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        @mkdir(__DIR__ . '/runtime');
    }

    public function testCompile(): array
    {
        $finder = Finder::create()->in([__DIR__ . '/Support'])->name('*.php');
        $rc = new RouteCompiler(new AnnotationLoader(new ClassLocator($finder)));

        $routes = $rc->compile();
        $template = <<<'EOT'
<?php
return %s;
EOT;

        $template = sprintf($template, VarDumper::create($routes)->export());
        @file_put_contents(__DIR__ . '/runtime/test.php', $template);

        $this->assertContainsOnlyInstancesOf(Group::class, $routes);
        return [$routes];
    }

    /**
     * @param $group Group
     *
     * @dataProvider testCompile
     */
    public function testCompiledRoutes(Group $group): void
    {
        $this->assertInstanceOf(Group::class, $group);
        $this->assertNotEmpty($group->getItems());
    }

    public function tearDown(): void
    {
        parent::tearDown();
        @unlink(__DIR__ . '/runtime/test.php');
        @rmdir(__DIR__ . '/runtime');
    }
}
