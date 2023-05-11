<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Level;
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

        $handlers = [
            new TeamsLogHandler(
                $config['url'],
                $config['level'] ?? Level::Debug,
                true,
                $formatter,
            ),
        ];

        return new Logger('app', $handlers);
    }
}
