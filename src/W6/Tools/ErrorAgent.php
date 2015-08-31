<?php
namespace W6\Tools;

class ErrorAgent
{
    public function __construct()
    {
        set_exception_handler(array($this, 'exceptionHandler'));
        set_error_handler(array($this, 'errorHandler'));
    }

    public function exceptionHandler($exception)
    {
        global $__agentConfig;

        $html = file_get_contents(dirname(__FILE__).'/template/exception.w6');
        $html = str_replace('###sitename###', $__agentConfig['sitename'], $html);
        $html = str_replace('###message###', $exception->getMessage(), $html);
        $html = str_replace('###file###', $exception->getFile(), $html);
        $html = str_replace('###line###', $exception->getLine(), $html);
        $html = str_replace('###code###', $exception->getCode(), $html);

        $server = $_SERVER['REMOTE_ADDR'];
        $server .= '<br>'.$_SERVER['HTTP_USER_AGENT'];

        $html = str_replace('###server###', $server, $html);

        if ($__agentConfig['sendEmail']) {
            $this->sendEmail($html);
        }

        print "Exception Caught: <span style='color:red'>". $exception->getMessage() ."</span><br>";
        print "File: ". $exception->getFile() ."<br>";
        print "Line: ". $exception->getLine() ."<br>";
        print "Code: ". $exception->getCode() ."<br><br><br>";
        exit();
    }

    public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            return;
        }
        global $__agentConfig;

        $html = file_get_contents(dirname(__FILE__).'/template/error.w6');
        $html = str_replace('###sitename###', $__agentConfig['sitename'], $html);
        $html = str_replace('###errno###', $errno, $html);
        $html = str_replace('###errstr###', $errstr, $html);
        $html = str_replace('###errfile###', $errfile, $html);
        $html = str_replace('###errline###', $errline, $html);

        $server = $_SERVER['REMOTE_ADDR'];
        $server .= '<br>'.$_SERVER['HTTP_USER_AGENT'];

        $html = str_replace('###server###', $server, $html);

        if ($__agentConfig['sendEmail']) {
            $this->sendEmail($html);
        }

        print "Error Code: ". $errno ."<br>";
        print "Error:  <span style='color:red'>". $errstr ."</span><br>";
        print "File: ". $errfile ."<br>";
        print "Line: ". $errline ."<br><br><br>";
        exit();
    }

    public function errorHandlerNoty($errno, $errstr, $errfile, $errline)
    {
        global $__agentConfig;

        $html = file_get_contents(dirname(__FILE__).'/template/error.w6');
        $html = str_replace('###sitename###', $__agentConfig['sitename'], $html);
        $html = str_replace('###errno###', $errno, $html);
        $html = str_replace('###errstr###', $errstr, $html);
        $html = str_replace('###errfile###', $errfile, $html);
        $html = str_replace('###errline###', $errline, $html);

        $server = $_SERVER['REMOTE_ADDR'];
        $server .= '<br>'.$_SERVER['HTTP_USER_AGENT'];

        $html = str_replace('###server###', $server, $html);


        if ($__agentConfig['sendEmail']) {
            $this->sendEmail($html);
        }
    }

    public function sendEmail($html)
    {
        global $__agentConfig;

        $message = \Swift_Message::newInstance()
            ->setSubject('ErrorAgent - '.$__agentConfig['sitename'])
            ->setFrom($__agentConfig['from'])
            ->setTo($__agentConfig['to'])
            ->setBody($html, 'text/html');

        $transport = \Swift_SmtpTransport::newInstance($__agentConfig['host'], $__agentConfig['port'])
        ->setUsername($__agentConfig['email'])
        ->setPassword($__agentConfig['password']);

        $mailer = \Swift_Mailer::newInstance($transport);

        $result = $mailer->send($message);
    }
}
