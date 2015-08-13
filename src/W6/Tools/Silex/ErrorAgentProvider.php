<?php
namespace W6\Tools\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;
use W6\Tools\ErrorAgent;

class ErrorAgentProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        new ErrorAgent();
    }

    public function boot(Application $app)
    {

    }
}