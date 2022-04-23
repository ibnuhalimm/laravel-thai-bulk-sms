<?php

namespace Ibnuhalimm\LaravelThaiBulkSms\Facades;

use Ibnuhalimm\LaravelThaiBulkSms\Services\ThaiBulkSms as IbnuhalimmThaiBulkSms;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed send($phoneNumber, $message)
 * @see Ibnuhalimm\LaravelThaiBulkSms\ThaiBulkSms
 */
class ThaiBulkSms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return IbnuhalimmThaiBulkSms::class;
    }
}
