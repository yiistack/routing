<?php

declare(strict_types=1);

namespace Yiistack\Routing\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;
use Yiisoft\Http\Method;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class Get extends Route
{
    public function __construct(array $values)
    {
        $values['methods'] = [Method::GET];

        parent::__construct($values);
    }
}
