<?php

namespace CMDISP\MonologMicrosoftTeams\Tests;

use CMDISP\MonologMicrosoftTeams\TeamsLogger;
use Monolog\Logger as Monolog;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class TeamsLoggerTest extends TestCase
{
    public function testInterfaces()
    {
        $url = 'https://example.com';
        $sut = new TeamsLogger($url);

        $this->assertInstanceOf(LoggerInterface::class, $sut);
        $this->assertInstanceOf(Monolog::class, $sut);
    }
}
