<?php

namespace HefeBot\Logger;

use Monolog\Logger;

class TelegramLogger {

    /**
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        return new Logger(
            'telegram', [
                $this->getHandler(
                    $config['level'],
                    isset($config['appName']) ? $config['appName'] : env('APP_NAME'),
                    $config['token']
                )
            ]
        );
    }

    public function getHandler($level, $appName, $token){
        return new TelegramHandler($level, $appName, $token);
    }

}