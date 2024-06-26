<?php

namespace Perscom\Data;

use Saloon\Contracts\Arrayable;

class ScopeObject implements Arrayable
{
    /**
     * @param  string  $name
     * @param  array  $parameters
     */
    public function __construct(public string $name, public array $parameters = [])
    {
        //
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        $body = [
            'name' => $this->name,
        ];

        if (filled($this->parameters)) {
            $body['parameters'] = $this->parameters;
        }

        return $body;
    }
}
