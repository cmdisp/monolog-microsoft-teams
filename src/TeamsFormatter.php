<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Formatter\FormatterInterface;
use Monolog\LogRecord;

class TeamsFormatter implements FormatterInterface
{
    public function format(LogRecord $record): array
    {
        return [
            'text' => '**' . $record->level->getName() . '**: ' . $record->message,
            'sections' => [
                [
                    'facts' => $this->facts($record->context),
                ],
            ],
        ];
    }

    public function formatBatch(array $records): array
    {
        foreach ($records as $key => $record) {
            $records[$key] = $this->format($record);
        }

        return $records;
    }

    private function facts(array $context): array
    {
        $facts = [];

        $normalized = (new \Monolog\Formatter\NormalizerFormatter())->normalizeValue($context);

        foreach ($normalized as $name => $value) {
            $facts[] = [
                'name' => $name,
                'value' => $this->formatHtml($value),
            ];
        }

        return $facts;
    }

    private function formatHtml($value)
    {
        if(is_scalar($value)){
            return $value;
        }

        $html = "<table>";
        foreach($value as $key => $v){
            $html .= "<tr>";
            $html .= "<td>$key</td>";

            if(is_scalar($v)){
                $html .= "<td>{$v}</td>";
            } else {
                foreach($v as $k2 => $v2){
                    if(is_scalar($v2)){
                        $html .= "$v2<br />";
                    } else {
                        $html .= "<br />";
                    }
                }
            }

            $html .= "</tr>";
        }

        $html .= "</table>";

        return $html;
    }
}
