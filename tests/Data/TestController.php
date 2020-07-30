<?php

declare(strict_types=1);

namespace Yiistack\Routing\Tests\Data;

use Yiistack\Routing\Annotation\Controller;
use Yiistack\Routing\Annotation\Get;

/**
 * @Controller("test")
 */
class TestController
{
    /**
     * @Get("/hello")
     */
    private function hello()
    {
        return 'hello';
    }
}
