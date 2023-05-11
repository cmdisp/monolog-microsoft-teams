<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class TeamsLogHandler extends AbstractProcessingHandler
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private static $levelColors = [
        Logger::DEBUG => '0080FF',
        Logger::INFO => '0080FF',
        Logger::NOTICE => '0080FF',
        Logger::WARNING => 'FF8000',
        Logger::ERROR => 'FF0000',
        Logger::CRITICAL => 'FF0000',
        Logger::ALERT => 'FF0000',
        Logger::EMERGENCY => 'FF0000',
    ];

    /**
     * @param int|string $level
     */
    public function __construct(
        string $url,
        $level = Logger::DEBUG,
        bool $bubble = true,
        FormatterInterface $formatter = null
    ) {
        parent::__construct($level, $bubble);

        $this->url = $url;

        if ($formatter) {
            $this->setFormatter($formatter);
        }
    }

    protected function getMessage(array $record): TeamsMessage
    {
        if ($this->formatter instanceof TeamsFormatter) {
            $data = $record['formatted'];
        } else {
            $data = [
                'title' => $record['level_name'] . ': ' . $record['message'],
                'text' => $record['formatted'],
            ];
        }

        $data['themeColor'] = $this->getThemeColor($record['level']);

        return new TeamsMessage($data);
    }

    protected function write(array $record): void
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

    private function getThemeColor(int $level): string
    {
        return self::$levelColors[$level] ?? self::$levelColors[$this->level];
    }
}
