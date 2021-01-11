<?php

use CMDISP\MonologMicrosoftTeams\TeamsMessage;
use PHPUnit\Framework\TestCase;

class TeamsMessageTest extends TestCase
{

    public function testInterfaces( ) {
        $sut = new TeamsMessage( array());
        $this->assertInstanceOf( \ArrayAccess::class, $sut);
        $this->assertInstanceOf( \JsonSerializable::class, $sut);
    }


    /**
     * @dataProvider provideMessageData
     */
    public function testGetter($data_key, $data_value ) {
        $sut = new TeamsMessage([
            $data_key => $data_value
        ]);
        $this->assertEquals( $sut[$data_key], $data_value);
        $this->assertEquals( $sut->offsetGet($data_key), $data_value);
    }

    public function provideMessageData()
    {
        return array(
            [ "foo", "bar"]
        );
    }
}
