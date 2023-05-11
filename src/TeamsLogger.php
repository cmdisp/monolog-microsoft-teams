<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Level;
use Monolog\Logger;

class TeamsLogger extends Logger
{
    /**
     * @param string $url
     * @param int|string|Level $level
     * @param bool $bubble
     */
    public function __construct(string $url, int|string|Level $level = Level::Debug, bool $bubble = true)
    {
        parent::__construct('teams-logger');

        $this->pushHandler(new TeamsLogHandler($url, $level, $bubble));
    }
}