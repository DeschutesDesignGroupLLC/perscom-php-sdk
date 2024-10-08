<?php

declare(strict_types=1);

namespace Perscom\Http\Requests\Units;

use Perscom\Http\Requests\AbstractSearchRequest;

class SearchUnitsRequest extends AbstractSearchRequest
{
    protected function getResource(): string
    {
        return 'units';
    }
}
