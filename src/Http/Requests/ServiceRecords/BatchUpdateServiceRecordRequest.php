<?php

declare(strict_types=1);

namespace Perscom\Http\Requests\ServiceRecords;

use Perscom\Http\Requests\AbstractBatchUpdateRequest;

class BatchUpdateServiceRecordRequest extends AbstractBatchUpdateRequest
{
    protected function getResource(): string
    {
        return 'service-records';
    }
}