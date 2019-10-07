<?php

namespace HefeBot\Logger;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

/**
 * Class TelegramHandler
 * @package HefeBot\Logger
 */
class TelegramHandler extends AbstractProcessingHandler
{
    protected $appName;

    protected $token;

    /**
     * TelegramHandler constructor.
     * @param $level
     * @param $appName
     * @param $token
     */
    public function __construct($level, $appName, $token)
    {
        $this->appName = $appName;
        $this->token = $token;

        parent::__construct($level, true);
    }

    /**
     * @param array $record
     */
    public function write(array $record): void
    {
        try {
            $client = new Client([
                'base_uri' => 'https://hefe.beedevs.com/api/log/'.$this->token,
                'timeout' => 2.0
            ]);

            $client->post('', [
                RequestOptions::JSON => [
                    'message' => $record['formatted'],
                    'log_level' => strtolower(Logger::getLevelName($record['level'])),
                    'app_id' => $this->appName,
                ]
            ]);

        } catch (Exception $exception) {

        }
    }
}