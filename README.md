<h1>monolog-telegram</h1>

<a href="https://packagist.org/packages/adellantado/monolog-telegram"><image src="https://img.shields.io/packagist/v/adellantado/monolog-telegram.svg"/></a>
<a href="https://packagist.org/packages/adellantado/monolog-telegram"><image src="https://img.shields.io/packagist/dt/adellantado/monolog-telegram.svg"/></a>
	
Use telegram bot [@hefebot](https://t.me/hefebot) to receive logs.

Run 

    composer require adellantado/monolog-telegram
	
<h2>Laravel Usage</h2>
	
   Visit [@hefebot](https://t.me/hefebot) to receive token
	
   and add config to logging.php
	
	'telegram' => [
        'driver' => 'custom',
        'via' => \HefeBot\Logger\TelegramLogger::class,
        'level' => 'warning',
        'token' => '<my_token>'
    ]
	
<h2>Monolog Usage</h2>	

   Visit [@hefebot](https://t.me/hefebot) to receive token

    use HefeBot\Logger\TelegramLogger;
    
    $config = [
        'level' => 'warning',
        'token' => '<my_token>',
        'appName' => 'My App'        
    ];
    
    $logger = new TelegramLogger();
    $log = $logger($config);
    
    $log->error('Hello World!');
    