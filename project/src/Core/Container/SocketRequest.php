<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 17.04.18
 * Time: 8:52
 */

namespace Core\Container;


class SocketRequest
{
    private $host;
    private $port = 80;
    private $url;
    private $method = 'GET';
    private $httpVersion = 'HTTP/1.1';
    private $timeout = 30;

    public function __construct(string $host, string $url)
    {
        $this->host = $host;
        $this->url = $url;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }

    /**
     * @param string $httpVersion
     */
    public function setHttpVersion(string $httpVersion): void
    {
        $this->httpVersion = $httpVersion;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @return string
     */
    public function getHttpVersion(): string
    {
        return $this->httpVersion;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }
}