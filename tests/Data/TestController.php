<?php


namespace Yiistack\Routing\Tests\Data;

use Yiistack\Routing\Annotation\Controller;
use Yiistack\Routing\Annotation\Get;

/**
 * Class TesController
 * @package Yiistack\Routing\Tests\Data
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
