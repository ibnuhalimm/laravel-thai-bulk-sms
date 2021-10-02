<?php

namespace Ibnuhalimm\LaravelThaiBulkSms;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Response;

class LaravelThaiBulkSms
{
    /**
     * @var string $baseApiUrl
     */
    protected $baseApiUrl = 'https://api-v2.thaibulksms.com';

    /**
     * @var string $apiKey
     */
    protected $apiKey;

    /**
     * @var string $secretKey
     */
    protected $secretKey;

    /**
     * @var string $authToken
     */
    protected $authToken;

    /**
     * @var Client $http
     */
    protected $http;

    /**
     * Create new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->apiKey = config('laravel-thai-bulk-sms.api_key');
        $this->secretKey = config('laravel-thai-bulk-sms.secret_key');
        $this->authToken = base64_encode($this->apiKey . ':' . $this->secretKey);

        $this->http = new Client(['base_uri' => $this->baseApiUrl]);
    }

    /**
     * Send sms
     *
     * @param  string|array  $mobileNumber
     * @param  string  $message
     * @return mixed
     */
    public function send($mobileNumber, $message)
    {
        $mobileNumber = is_array($mobileNumber) ? implode(',', $mobileNumber) : $mobileNumber;

        $formParams['msisdn'] = (string)$mobileNumber;
        $formParams['message'] = $message;

        try {
            $response = $this->http->request('POST', '/sms', [
                'auth' => [
                    $this->apiKey, $this->secretKey
                ],
                'form_params' => $formParams
            ]);

            $result = (object)[
                'code' => $response->getStatusCode()
            ];

            $responseBody = json_decode($response->getBody()->getContents(), true);
            $result->error = null;
            $result->data = (object)$responseBody;

            return $result;
        } catch (ClientException $e) {
            $response = $e->getResponse();

            $result = (object)[
                'code' => $response->getStatusCode()
            ];

            $responseBody = json_decode($response->getBody()->getContents(), true);
            $result->data = null;
            $result->error = (object)[
                'name' => $responseBody['error']['name'],
                'description' => $responseBody['error']['description']
            ];

            return $result;
        } catch (ServerException $e) {
            $response = $e->getResponse();

            $result = (object)[
                'code' => $response->getStatusCode()
            ];

            $responseBody = json_decode($response->getBody()->getContents(), true);
            $result->data = null;
            $result->error = (object)[
                'name' => $responseBody['error']['name'],
                'description' => $responseBody['error']['description']
            ];

            return $result;
        }
    }
}
