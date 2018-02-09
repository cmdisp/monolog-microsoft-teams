# monolog-microsoft-teams

Monolog Handler for sending messages to Microsoft Teams channels using the Incoming WebHook connector.

## Install

```bash
$ composer require cmdisp/monolog-microsoft-teams
```

## Usage

```php
$logger = new \CMDISP\MonologMicrosoftTeams\TeamsLogger('INCOMING_WEBHOOK_URL', \Monolog\Logger::ERROR);
$logger->error('Error message');
```

or

```php
$logger = new \Monolog\Logger('app');
$logger->pushHandler(new \CMDISP\MonologMicrosoftTeams\TeamsLogHandler('INCOMING_WEBHOOK_URL', \Monolog\Logger::ERROR));
```

## Usage with Laravel/Lumen framework (5.6+)

Create a [custom channel](https://laravel.com/docs/master/logging#creating-custom-channels) 

`config/logging.php`

```php
'teams' => [
    'driver' => 'custom',
    'via' => \CMDISP\MonologMicrosoftTeams\TeamsLogChannel::class,
    'level' => 'error',
    'url' => 'INCOMING_WEBHOOK_URL',
],
```

Send an error message to the teams channel:

```php
Log::channel('teams')->error('Error message');
```

You can also add `teams` to the default `stack` channel so all errors are automatically send to the `teams` channel.

```php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'teams'],
    ],
],
```

## License

monolog-microsoft-teams is available under the MIT license. See the LICENSE file for more info.