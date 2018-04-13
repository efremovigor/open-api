<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 13.04.18
 * Time: 16:39
 */

namespace Core;


class LogItem
{
    private $level;
    private $time;
    private $message;

    public function __construct(string $level, string $message)
    {
        $this->time = time();
        $this->level = $level;
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}