<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Level;

class TeamsLogChannel
{
    /**
     * @param array $config
     *
     * @return TeamsLogger
     */
    public function __invoke(array $config): TeamsLogger
    {
        return new TeamsLogger($config['url'], $config['level'] ?? Level::Debug);
    }
}
