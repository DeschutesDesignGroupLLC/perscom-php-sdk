<?php

namespace Perscom\Http\Requests\Calendars;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCalendarRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param int $id
     */
    public function __construct(protected int $id)
    {
        //
    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return "calendars/{$this->id}";
    }
}
