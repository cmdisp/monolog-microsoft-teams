<?php

namespace CMDISP\MonologMicrosoftTeams\Tests;

use ArrayAccess;
use CMDISP\MonologMicrosoftTeams\TeamsMessage;
use JsonSerializable;
use PHPUnit\Framework\TestCase;

class TeamsMessageTest extends TestCase
{
    public function testInterfaces(): void
    {
        $message = new TeamsMessage();
        $this->assertInstanceOf(ArrayAccess::class, $message);
        $this->assertInstanceOf(JsonSerializable::class, $message);
    }

    /**
     * @dataProvider provideMessageData
     */
    public function testGetter(string $dataKey, string $dataValue)
    {
        $message = new TeamsMessage([
            $dataKey => $dataValue
        ]);

        $this->assertEquals($message[$dataKey], $dataValue);
        $this->assertEquals($message->offsetGet($dataKey), $dataValue);
    }

    public static function provideMessageData(): array
    {
        return [
            ['foo', 'bar']
        ];
    }
}
