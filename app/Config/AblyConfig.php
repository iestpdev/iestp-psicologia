<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class AblyConfig extends BaseConfig
{
    public string $apiKey;
    public string $channelName;
    public string $eventName;

    public function __construct()
    {
        parent::__construct();

        $this->apiKey = getenv('ably.apiKey') ?: '';
        $this->channelName = getenv('ably.channelName') ?: 'iestp-psycho-updates';
        $this->eventName = getenv('ably.eventName') ?: 'dashboard_update';
    }
}