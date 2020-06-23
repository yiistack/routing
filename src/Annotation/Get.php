<?php

declare(strict_types=1);

namespace Yiistack\Routing\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;
use Yiisoft\Http\Method;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Get extends Action
{
    protected array $methods = [Method::GET];
    private string $route;
    private $values;

    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->route = $values['value'];
        }
        $this->values = $values;
    }

    public function getRoute(): string
    {
        return $this->route;
    }
}
