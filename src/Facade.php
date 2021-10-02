<?php

namespace Ibnuhalimm\LaravelThaiBulkSms;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

/**
 * @see \Ibnuhalimm\LaravelThaiBulkSms\Skeleton\SkeletonClass
 */
class Facade extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-thai-bulk-sms';
    }
}
