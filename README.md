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



## Unit testing · PhpUnit

The tests require a valid Teams [Incoming Webhook URL.](https://docs.microsoft.com/en-us/microsoftteams/platform/concepts/connectors/connectors-using) To provide this URL to PhpUnit, copy `phpunit.xml.dist` to `phpunit.xml`and set the URL in the `<php>` section. Make sure to not commit your local *phpunit.xml* into the repo!

```xml
	<php>
		<env name="TEAMS_INCOMING_WEBHOOK_URL" value="https://outlook.office.com/webhook/many-many-letters" />
	</php>
```

Run the tests on the comman line:

```bash
$ composer test
```



## License

monolog-microsoft-teams is available under the MIT license. See the LICENSE file for more info.