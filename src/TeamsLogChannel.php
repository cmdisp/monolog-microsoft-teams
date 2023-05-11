<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Logger;
use Psr\Log\LoggerInterface;

class TeamsLogChannel
{
    public function __invoke(array $config): LoggerInterface
    {
        $formatter = null;
        if (isset($config['formatter'])) {
            $formatter = new $config['formatter']();
        }

        return new TeamsLogger(
            $config['url'],
            $config['level'] ?? Logger::DEBUG,
            true,
            $formatter
        );
    }
}
