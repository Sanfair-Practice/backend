<?php

namespace App\Enums\Variant;

final class Status
{
    public const CREATED = 'created';
    public const STARTED = 'started';
    public const PASSED = 'finished';
    public const FAILED = 'failed';
    public const EXPIRED = 'expired';
}
