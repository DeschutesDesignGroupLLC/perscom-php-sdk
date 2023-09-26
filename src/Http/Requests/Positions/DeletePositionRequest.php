<?php

namespace Perscom\Http\Requests\Positions;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeletePositionRequest extends Request
{
    protected Method $method = Method::DELETE;

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
        return "positions/{$this->id}";
    }
}
