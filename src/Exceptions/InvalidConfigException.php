<?php

namespace Ibnuhalimm\LaravelThaiBulkSms\Exceptions;

class InvalidConfigException extends \Exception
{
    public static function missingApiAndSecretKey(): self
    {
        return new static("Missing API and Secret Key Config.");
    }
}