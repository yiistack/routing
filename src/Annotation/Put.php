<?php

declare(strict_types=1);

namespace Yiistack\Routing\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;
use Yiisoft\Http\Method;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class Put extends Action
{
    private string $route;

    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->route = $values['value'];
        }
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getMethods(): array
    {
        return [Method::PUT];
    }
}
