<?php

use CMDISP\MonologMicrosoftTeams\TeamsLogger;
use Psr\Log\LoggerInterface;
use Monolog\Logger as Monolog;
use PHPUnit\Framework\TestCase;

class TeamsLoggerTest extends TestCase
{

    public function testInterfaces( ) {
        $url = '';
        $sut = new TeamsLogger( $url);
        $this->assertInstanceOf( LoggerInterface::class, $sut);
        $this->assertInstanceOf( Monolog::class, $sut);
    }


}
