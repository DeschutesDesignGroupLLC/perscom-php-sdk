<?php

declare(strict_types=1);

namespace Perscom\Http\Requests\Announcements;

use Perscom\Http\Requests\AbstractSearchRequest;

class SearchAnnouncementsRequest extends AbstractSearchRequest
{
    protected function getResource(): string
    {
        return 'announcements';
    }
}
