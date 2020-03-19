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
        $lvlNumber = $record['level'];
        if (function_exists('cache') && function_exists('now')) {
            $lvl = cache('_hefe_log_level');
            if (!$lvl) {
                $r = $this->send($record);
                if (is_array($r) && array_key_exists('minLevel', $r)) {
                    cache(['_hefe_log_level' => $r['minLevel']], now()->addDays(1));
                }
                return;
            }

            if ($lvlNumber >= $lvl) {
                $this->send($record);
            }

        } else {
            if ($lvlNumber >= Logger::ERROR) {
                $this->send($record);
            }
        }
    }

    protected function send(array $record){
        try {

            $client = new Client([
                'base_uri' => 'https://hefe.beedevs.com/api/log/'.$this->token,
                'timeout' => 2.0
            ]);

           $r = $client->post('', [
                RequestOptions::JSON => [
                    'message' => $record['formatted'],
                    'log_level' => strtolower(Logger::getLevelName($record['level'])),
                    'app_id' => $this->appName,
                ]
            ]);

            return json_decode((string)$r->getBody(), true);

        } catch (Exception $exception) {
            return null;
        }

    }
}