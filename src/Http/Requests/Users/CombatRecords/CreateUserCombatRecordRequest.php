<?php

namespace Perscom\Http\Requests\Users\CombatRecords;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateUserCombatRecordRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param int $userId
     * @param array<string, mixed>  $data
     */
    public function __construct(public int $userId, public array $data)
    {
        //
    }

    /**
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return "users/{$this->userId}/combat-records";
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
