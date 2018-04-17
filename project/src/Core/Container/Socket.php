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
        $response = new SocketResponse();
        $fp = fsockopen($request->getProtocol() . '://' . $request->getHost(), $request->getPort(), $errno, $errstr, $request->getTimeout());
        $out = $request->getMethod() . ' ' . $request->getUrl() . ' ' . $request->getHttpVersion() . "\r\n";
        $out .= 'Host: ' . $request->getHost() . "\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fwrite($fp, $out);
        while (!feof($fp)) {
            $response->add(fgets($fp, 128));
        }
        return $response;
    }
}