<?php

namespace Ibnuhalimm\LaravelThaiBulkSms;

class ThaiBulkSmsConfig
{
    /** @var array $config */
    private $config;

    /** @var string $baseApiUrl */
    private $baseApiUrl = 'https://api-v2.thaibulksms.com';

    /**
     * Create new instance
     *
     * @param  array  $config
     * @return void
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get base api url
     *
     * @return string
     */
    public function getBaseApiUrl()
    {
        return $this->baseApiUrl;
    }

    /**
     * Get api key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->config['api_key'] ?? null;
    }

    /**
     * Get secret key
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->config['secret_key'] ?? null;
    }

    /**
     * Get auth token
     *
     * @return string
     */
    public function getAuthToken()
    {
        return base64_encode($this->getApiKey() . ':' . $this->getSecretKey());
    }
}