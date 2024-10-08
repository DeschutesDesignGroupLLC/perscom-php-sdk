<?php

declare(strict_types=1);

namespace Perscom\Http\Requests\Ranks;

use Perscom\Http\Requests\AbstractSearchRequest;

class SearchRanksRequest extends AbstractSearchRequest
{
    protected function getResource(): string
    {
        return 'ranks';
    }
}
