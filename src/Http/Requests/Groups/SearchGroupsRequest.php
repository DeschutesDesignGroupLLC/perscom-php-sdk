<?php

declare(strict_types=1);

namespace Perscom\Http\Requests\Groups;

use Perscom\Http\Requests\AbstractSearchRequest;

class SearchGroupsRequest extends AbstractSearchRequest
{
    /**
     * {@inheritDoc}
     */
    protected function getResource(): string
    {
        return 'groups';
    }
}
