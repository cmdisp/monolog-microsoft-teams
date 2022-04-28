<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Formatter\FormatterInterface;

class TeamsFormatter implements FormatterInterface
{
    /**
     * @param string $dateFormat
     */
    public function __construct(string $dateFormat = 'Y-m-d H:i:s')
    {
        $this->dateFormat = $dateFormat;
    }

    /**
     * formats a log record into teams card format
     *
     * @param array $record
     * @return array
     */
    public function format(array $record): array
    {
        return [
            'title' => $record['level_name'] . ' : ' . $record['message'],
            'text' => sprintf('Channel %s on %s', $record['channel'], $record['datetime']->format($this->dateFormat)),
            'sections' => [
                [
                    'facts' => $this->convertToFact($record['context']),
                    'markdown' => true,
                ],
            ],
        ];
    }

    /**
     * convert log context into facts card component
     *
     * @param array<string> $context
     * @return array
     */
    private function convertToFact(array $context): array
    {
        $facts = [];
        foreach ($context as $name => $value) {
            $facts[] = compact('name', 'value');
        }
        return $facts;
    }

    /**
     * {@inheritDoc}
     */
    public function formatBatch(array $records): array
    {
        return array_map(function ($record) {
            $this->format($record);
        }, $records);
    }
}
