<?php

namespace Ibnuhalimm\LaravelThaiBulkSms;

use Ibnuhalimm\LaravelThaiBulkSms\Exceptions\CouldNotSendNotification;
use Ibnuhalimm\LaravelThaiBulkSms\Services\ThaiBulkSms;
use Illuminate\Notifications\Notification;

class ThaiBulkSmsChannel
{
    /** @var ThaiBulkSms */
    protected $thaiBulkSms;

    public function __construct(ThaiBulkSms $thaiBulkSms)
    {
        $this->thaiBulkSms = $thaiBulkSms;
    }


    public function send($notifiable, Notification $notification)
    {
        $to = $this->getRecipientMobileNumber($notifiable, $notification);
        $message = $notification->toThaiBulkSms($notifiable);

        if (is_string($message)) {
            $message = ThaiBulkSmsMessage::create($message);
        }

        return $this->thaiBulkSms->send($to, $message);
    }

    /**
     * Get the mobile phone number to send the notification to
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification|null  $notification
     *
     * @return string
     */
    protected function getRecipientMobileNumber($notifiable, $notication)
    {
        if ($notifiable->routeNotificationFor(self::class, $notication)) {
            return $notifiable->routeNotificationFor(self::class, $notication);
        }

        if ($notifiable->routeNotificationFor('thai-bulk-sms', $notication)) {
            return $notifiable->routeNotificationFor('thai-bulk-sms', $notication);
        }

        if (isset($notifiable->mobile_number)) {
            return $notifiable->mobile_number;
        }

        throw CouldNotSendNotification::recipientNotProvided();
    }
}