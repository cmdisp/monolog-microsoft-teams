<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;

class TeamsLogHandler extends AbstractProcessingHandler
{
    public function __construct(
        private readonly string $url,
        int|string|Level $level = Level::Debug,
        bool $bubble = true,
        FormatterInterface $formatter = null,
    ) {
        parent::__construct($level, $bubble);

        $this->setFormatter($formatter ?? new TeamsFormatter());
    }

    protected function write(LogRecord $record): void
    {
        $json = json_encode($this->teamsMessage($record));

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

    private function teamsMessage(LogRecord $record): TeamsMessage
    {
        if ($this->formatter instanceof TeamsFormatter) {
            $data = $record->formatted;
        } else {
            $data = [
                'title' => $record->level->getName() . ': ' . $record->message,
                'text' => $record->formatted,
            ];
        }

        $data['themeColor'] = $this->themeColor($record->level);

        return new TeamsMessage($data);
    }

    private function themeColor(Level $level): string
    {
        return match ($level) {
            Level::Warning => 'FF8000',
            Level::Error, Level::Critical, Level::Alert, Level::Emergency => 'FF0000',
            default => '0080FF',
        };
    }
}
