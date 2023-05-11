<?php

namespace CMDISP\MonologMicrosoftTeams\Tests;

use CMDISP\MonologMicrosoftTeams\TeamsLogHandler;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class TeamsLogHandlerTest extends TestCase
{
    private string $incomingWebHookUrl;

    public function setUp(): void
    {
        parent::setUp();

        if (!$this->incomingWebHookUrl = getenv('TEAMS_INCOMING_WEBHOOK_URL')) {
            throw new RuntimeException('Please fill in TEAMS_INCOMING_WEBHOOK_URL in phpunit.xml');
        }
    }

    private function createLogHandler(): TeamsLogHandler
    {
        return new TeamsLogHandler($this->incomingWebHookUrl);
    }

    public function testInstantiation(): void
    {
        $logHandler = $this->createLogHandler();

        $this->assertInstanceOf(AbstractProcessingHandler::class, $logHandler);
    }

    public function testUsage(): void
    {
        $logHandler = $this->createLogHandler();

        $monolog = new Logger('TeamsLogHandlerTest');
        $monolog->pushHandler($logHandler);

        // "isHandling" will return false when no handlers at all are registered with Monolog.
        $this->assertTrue($monolog->isHandling(Level::Debug));

        // Send a message
        $result = $monolog->addRecord(Level::Debug, 'test', ['foo' => 'bar']);
        $this->assertTrue($result);
    }
}
