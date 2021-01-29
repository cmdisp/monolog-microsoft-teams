<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Logger;
use Psr\Log\LoggerInterface;

class TeamsLogChannel
{
    /**
     * @param array $config
     *
     * @return LoggerInterface
     */
    public function __invoke(array $config)
    {
        return new TeamsLogger($config['url'], $config['level'] ?? Logger::DEBUG);
    }
}
