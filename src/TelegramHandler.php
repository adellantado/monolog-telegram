<?php

namespace HefeBot\Logger;

use Exception;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class TelegramHandler extends AbstractProcessingHandler
{
    protected $appName;

    protected $token;

    /**
     * TelegramHandler constructor.
     * @param int $level
     */
    public function __construct($level, $appName, $token)
    {
        $this->appName = $appName;
        $this->token = $token;
        $level = Logger::toMonologLevel($level);

        parent::__construct($level, true);
    }

    /**
     * @param array $record
     */
    public function write(array $record)
    {
        try {
            file_get_contents(
                'https://hefe.beedevs.com/' . $this->token
                . http_build_query([
                    'message' => $record['formatted'],
                    'level' => $record['level_name'],
                    'name' => $this->appName
                ])
            );
        } catch (Exception $exception) {

        }
    }
}