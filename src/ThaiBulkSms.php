<?php

namespace Ibnuhalimm\LaravelThaiBulkSms;

class ThaiBulkSms
{
    /** @var ThaiBulkSmsClient */
    protected $client;

    /**
     * Create new instance.
     *
     * @param  ThaiBulkSmsClient  $client
     * @return void
     */
    public function __construct(ThaiBulkSmsClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send the sms
     *
     * @param  string|array  $mobileNumber
     * @param  string  $message
     * @return mixed
     */
    public function send($mobileNumber, $message)
    {
        $mobileNumber = is_array($mobileNumber) ? implode(',', $mobileNumber) : $mobileNumber;
        return $this->client->sendSms($mobileNumber, $message);
    }
}
