<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Level;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;

class TeamsLogHandler extends AbstractProcessingHandler
{
    private string $url;

    /**
     * @var array
     */
    private static array $levelColors = [
        'DEBUG' => '0080FF',
        'INFO' => '0080FF',
        'NOTICE' => '0080FF',
        'WARNING' => 'FF8000',
        'ERROR' => 'FF0000',
        'CRITICAL' => 'FF0000',
        'ALERT' => 'FF0000',
        'EMERGENCY' => 'FF0000',
    ];

    /**
     * @param string $url
     * @param int|string|Level $level
     * @param bool $bubble
     */
    public function __construct(string $url, int|string|Level $level = Level::Debug, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->url = $url;
    }

    /**
     * @param LogRecord $record
     *
     * @return TeamsMessage
     */
    protected function getMessage(LogRecord $record): TeamsMessage
    {
        return new TeamsMessage([
            'title' => $record->level->getName() . ': ' . $record->message,
            'text' => $record->formatted,
            'themeColor' => self::$levelColors[$record->level->getName()] ?? self::$levelColors[$this->level->getName()],
        ]);
    }

    /**
     * Writes the (already formatted) record down to the log of the implementing handler
     */
    protected function write(LogRecord $record): void
    {
        $json = json_encode($this->getMessage($record));

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json)
        ]);

        curl_exec($ch);
    }
}
