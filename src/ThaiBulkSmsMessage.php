<?php

namespace Ibnuhalimm\LaravelThaiBulkSms;

class ThaiBulkSmsMessage
{
    /** @var string $message */
    public $message;

    /** @var string|array  $mobileNumbers */
    public $mobileNumbers;

    /**
     * Create new instance
     *
     * @param  string  $message
     * @return void
     */
    public function __construct(string $message = '')
    {
        if (!empty($message)) {
            $this->message = $message;
        }
    }

    /**
     * @param  string  $message
     * @return static
     */
    public static function create(string $message = ''): self
    {
        return new static($message);
    }

    /**
     * SMS text
     *
     * @param  string  $message
     * @return $this
     */
    public function message(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Recipient phone number
     *
     * @param  string|array  $mobileNumbers
     * @return $this
     */
    public function to($mobileNumbers)
    {
        $recipient = is_array($mobileNumbers) ? implode(',', $mobileNumbers) : $mobileNumbers;
        $this->mobileNumbers = $recipient;

        return $this;
    }
}