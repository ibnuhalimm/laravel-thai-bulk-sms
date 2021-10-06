<?php

namespace Ibnuhalimm\LaravelThaiBulkSms\Services;

class ThaiBulkSms
{
    /** @var HttpClient */
    protected $client;

    /**
     * Create new instance.
     *
     * @param  HttpClient  $client
     * @return void
     */
    public function __construct(HttpClient $client)
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
