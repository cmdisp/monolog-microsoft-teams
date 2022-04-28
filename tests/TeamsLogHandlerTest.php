<?php

namespace CMDISP\MonologMicrosoftTeams\Tests;

use CMDISP\MonologMicrosoftTeams\TeamsLogHandler;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class TeamsLogHandlerTest extends TestCase
{
    /**
     * @var string
     */
    private $incomingWebHookUrl;

    /**
     * @var int
     */
    private $loglevel = Logger::DEBUG;

    public function setUp(): void
    {
        parent::setUp();

        if (!$this->incomingWebHookUrl = getenv('TEAMS_INCOMING_WEBHOOK_URL')) {
            throw new RuntimeException('Please fill in TEAMS_INCOMING_WEBHOOK_URL in phpunit.xml');
        }
    }

    private function createLogHandler(): TeamsLogHandler
    {
        return new TeamsLogHandler($this->incomingWebHookUrl, $this->loglevel);
    }

    public function testInstantiation()
    {
        $logHandler = $this->createLogHandler();

        $this->assertInstanceOf(AbstractProcessingHandler::class, $logHandler);
    }

    public function testUsage()
    {
        $logHandler = $this->createLogHandler();

        $monolog = new Logger('TeamsLogHandlerTest');
        $monolog->pushHandler($logHandler);

        // "isHandling" will return FALSE when no handlers at all are registered with monolog.
        $this->assertTrue($monolog->isHandling($this->loglevel));

        // Send a message
        $result = $monolog->addRecord($this->loglevel, 'test', ['foo' => 'bar']);
        $this->assertTrue($result);
    }
}
