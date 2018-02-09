<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Logger;

class TeamsLogChannel
{
    /**
     * @param array $config
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function __invoke(array $config)
    {
        return new TeamsLogger($config['url'], $config['level'] ?? Logger::DEBUG);
    }
}