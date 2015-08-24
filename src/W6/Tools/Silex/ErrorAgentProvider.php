<?php
namespace W6\Tools\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;
use W6\Tools\ErrorAgent;

class ErrorAgentProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $errorAgent = new ErrorAgent();
        $app['errorAgent'] = $errorAgent;
    }

    public function boot(Application $app)
    {

    }
}
