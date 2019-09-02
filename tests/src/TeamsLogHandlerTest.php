<?php 
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use CMDISP\MonologMicrosoftTeams\TeamsLogHandler;
use CMDISP\MonologMicrosoftTeams\TeamsMessage;

class TeamsLogHandlerTest extends \PHPUnit\Framework\TestCase
{	

	public $incoming_webook_url;
	public $loglevel = Logger::DEBUG;


	public function setUp()
	{
		parent::setUp();
		if (!$this->incoming_webook_url = getenv('TEAMS_INCOMING_WEBHOOK_URL')) {
			throw new \RuntimeException( "Please fill in TEAMS_INCOMING_WEBHOOK_URL in phpunit.xml");
		}
	}


	public function createSut()
	{
		return new TeamsLogHandler( $this->incoming_webook_url, $this->loglevel );
	}


	public function testInstantiation()
	{
		$sut = $this->createSut();
		$this->assertInstanceOf( AbstractProcessingHandler::class, $sut);
	}


	public function testUsage()
	{
		$sut = $this->createSut();

		$monolog = new Logger("TeamsLogHandlerTest");
		$monolog->pushHandler( $sut );

		// "isHandling" will return FALSE when no handlers at all 
		// are registered with monolog.
		$this->assertTrue( $monolog->isHandling( $this->loglevel ));

		// Send a message
		$result = $monolog->addRecord( $this->loglevel, 'test');
		$this->assertTrue( $result );

	}

}