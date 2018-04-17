<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 17.04.18
 * Time: 8:50
 */

namespace Core\Container;


class Socket extends AbstractContainerItem
{

    public function call(SocketRequest $request): SocketResponse
    {
        $connect = fsockopen($request->getHost(), $request->getPort(), $errno, $errstr, $request->getTimeout());
        if ($connect === false) {
            throw new \Exception();
        }
        $out = $request->getMethod() . ' ' . $request->getUrl() . ' ' . $request->getHttpVersion() . "\r\n";
        $out .= 'Host: ' . $request->getHost() . "\r\n";
        $out .= "Connection: Close\r\n\r\n";
        $response = new SocketResponse();
        fwrite($connect, $out);
        while (!feof($connect)) {
            $response->add(fgets($connect, 128));
        }
        return $response;
    }

    public function init(): void
    {
        // TODO: Implement init() method.
    }
}