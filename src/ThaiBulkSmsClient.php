<?php

namespace Ibnuhalimm\LaravelThaiBulkSms;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Ibnuhalimm\LaravelThaiBulkSms\Exceptions\CouldNotSendNotification;

class ThaiBulkSmsClient
{
    /** @var ConfigRepository */
    private $config;

    /** @var GuzzleHttp/Client */
    private $http;

    public function __construct(ConfigRepository $config)
    {
        $this->config = $config;

        $this->http = new Client([
            'base_uri' => $this->config->getBaseApiUrl()
        ]);
    }


    public function sendSms($mobileNumber, $message)
    {
        $formParams['msisdn'] = $mobileNumber;
        $formParams['message'] = $message;

        try {
            $response = $this->http->request('POST', '/sms', [
                'auth' => [$this->config->getApiKey(), $this->config->getSecretKey()],
                'form_params' => $formParams
            ]);

            return json_decode($response->getBody()->getContents(), false);
        } catch (ClientException $e) {
            return json_decode($e->getResponse()->getBody(), false);
        } catch (ServerException $e) {
            throw CouldNotSendNotification::thaiBulkRespondedWithAnError($e);
        } catch (\Exception $e) {
            throw CouldNotSendNotification::couldNotCommuniateWithThaiBulkSms($e);
        }
    }
}