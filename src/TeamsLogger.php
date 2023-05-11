<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Formatter\FormatterInterface;
use Monolog\Logger;

class TeamsLogger extends Logger
{
    /**
     * @param int|string $level
     */
    public function __construct(
        string $url,
        $level = Logger::DEBUG,
        bool $bubble = true,
        FormatterInterface $formatter = null
    ) {
        parent::__construct('teams-logger');

        $this->pushHandler(new TeamsLogHandler($url, $level, $bubble, $formatter));
    }
}
