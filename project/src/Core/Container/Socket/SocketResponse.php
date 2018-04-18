<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 17.04.18
 * Time: 10:27
 */

namespace Core\Container\Socket;


class SocketResponse
{
    private $answer = '';

    public function add(string $answer): void
    {
        $this->answer .= $answer;
    }

    /**
     * @return mixed
     */
    public function getHead()
    {
        return explode("\n\r",$this->answer)[0];
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return explode("\n\r",$this->answer)[1];
    }
}