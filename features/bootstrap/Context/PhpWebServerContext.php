<?php

namespace App\Features\Context;

use Behat\Behat\Context\Context;
use Symfony\Component\Process\Process;

class PhpWebServerContext implements Context
{

    const TIMEOUT = 10;

    /**
     * @var Process
     */
    protected $process;

    /**
     * @var string
     */
    private $webroot;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    public function __construct(string $webroot = './public', string $host = 'localhost', int $port = 8000)
    {
        $this->webroot = $webroot;
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @BeforeScenario @run-server
     *
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     * @throws \Symfony\Component\Process\Exception\LogicException
     */
    public function startServerProcess(): void
    {
        $this->process = new Process(sprintf('exec php -S %s:%d -t %s', $this->host, $this->port, $this->webroot));
        $this->process->start();

        /*
         * This is required due to starting the process not being immediate (and happening in the background)
         * Because of this, the scenarios can start executing before the server is ready, which causes them to fail.
         *
         * This checks for the server to be available before proceeding on with things.
         *
         * Hey, it works - don't judge.
         */
        while (@fsockopen($this->host, $this->port) === false) {
            usleep(1000);
        }
    }

    /**
     * @AfterScenario @run-server
     */
    public function stopServerProcess(): void
    {
        $this->process->stop(self::TIMEOUT, SIGTERM);
        $this->process = null;
    }
}
