<?php

namespace CMDISP\MonologMicrosoftTeams\Tests;

use ArrayAccess;
use CMDISP\MonologMicrosoftTeams\TeamsMessage;
use JsonSerializable;
use PHPUnit\Framework\TestCase;

class TeamsMessageTest extends TestCase
{
    public function testInterfaces()
    {
        $sut = new TeamsMessage(array());
        $this->assertInstanceOf(ArrayAccess::class, $sut);
        $this->assertInstanceOf(JsonSerializable::class, $sut);
    }

    /**
     * @dataProvider provideMessageData
     *
     * @param $dataKey
     * @param $dataValue
     */
    public function testGetter($dataKey, $dataValue)
    {
        $sut = new TeamsMessage([
            $dataKey => $dataValue
        ]);

        $this->assertEquals($sut[$dataKey], $dataValue);
        $this->assertEquals($sut->offsetGet($dataKey), $dataValue);
    }

    public function provideMessageData(): array
    {
        return [
            ['foo', 'bar']
        ];
    }
}
