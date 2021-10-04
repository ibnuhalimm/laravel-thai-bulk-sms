<?php

namespace Ibnuhalimm\LaravelThaiBulkSms\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function recipientNotProvided()
    {
        return new static("Thai Bulk SMS recipient Mobile Numbers was not provided.");
    }

    public static function thaiBulkRespondedWithAnError(\Exception $exception)
    {
        if ($exception->hasResponse()) {
            $result = json_decode($exception->getResponse()->getBody(), false);

            return new static("Thai Bulk SMS responded with an error `{$result->error->code} - {$result->error->name} {$result->error->description}`");
        }

        return new static("Thai Bulk SMS responded with an error");
    }

    public static function couldNotCommuniateWithThaiBulkSms(\Exception $exception)
    {
        return new static("The communication with Thai Bulk SMS failed. Reason: {$exception->getMessage()}");
    }
}