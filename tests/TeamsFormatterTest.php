<?php

namespace CMDISP\MonologMicrosoftTeams\Tests;

use CMDISP\MonologMicrosoftTeams\TeamsFormatter;
use Monolog\Formatter\FormatterInterface;
use PHPUnit\Framework\TestCase;

class TeamsFormatterTest extends TestCase
{
    public function testInterface(): void
    {
        $formatter = new TeamsFormatter();

        $this->assertInstanceOf(FormatterInterface::class, $formatter);
    }
}
