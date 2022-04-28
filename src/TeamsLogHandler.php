<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Formatter\FormatterInterface;
use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

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
     * @param string $url
     * @param int|string $level
     * @param bool $bubble
     */
    public function __construct($url, $level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->url = $url;
    }

    /**
     * @param array $record
     *
     * @return TeamsMessage
     */
    protected function getMessage(array $record): TeamsMessage
    {
        return new TeamsMessage($this->getTeamsMessageData($record));
    }
    
    /**
     * privides initial data for teams message class depending on the formatter
     *
     * @param array $record
     * @return array
     */
    private function getTeamsMessageData(array $record): array
    {
        $themeColor = $this->getThemeColor($record['level']);

        if ($this->formatter instanceof TeamsFormatter) {
            return array_merge($record['formatted'], ['themeColor' => $themeColor]);
        }
        
        return [
            'title' => $record['level_name'] . ': ' . $record['message'],
            'text' => $record['formatted'],
            'themeColor' => $themeColor,
        ];
    }
    
    /**
     * returns theme color according to log level
     *
     * @param integer $level
     * @return string
     */
    private function getThemeColor(int $level):string
    {
        return self::$levelColors[$level] ?? self::$levelColors[$this->level];
    }

    /**
     * @param array $record
     */
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

    /**
     * Teams specific formatter
     *
     * @return FormatterInterface
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new TeamsFormatter();
    }
}
