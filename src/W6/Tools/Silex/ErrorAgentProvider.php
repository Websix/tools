<?php
namespace W6\Tools\Silex;

use Silex\ServiceProviderInterface;
use W6\Tools\ErrorAgent;

class ErrorAgentProvider implements ServiceProviderInterface
{

    public function __construct()
    {
        return new ErrorAgent();
    }

    public function register(Application $app)
    {

    }

    public function boot(Application $app)
    {

    }
}