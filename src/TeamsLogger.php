<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Logger;

class TeamsLogger extends Logger
{
    /**
     * @param $url
     * @param int $level
     * @param bool $bubble
     */
    public function __construct($url, $level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct('teams-logger');

        $this->pushHandler(new TeamsLogHandler($url, $level, $bubble));
    }
}