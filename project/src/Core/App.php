<?php

namespace Core;

class App extends AppKernel
{
    /**
     * @var RequestHandler
     */
    private $requestHandler;

    /**
     * AppKernel constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    public function run(): void
    {
        $this->requestHandler->process();
    }

    private function init(): void
    {
        $this->initRequest();
    }

    private function initRequest(): void
    {
        $this->requestHandler = new RequestHandler();
    }
}
