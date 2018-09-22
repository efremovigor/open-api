<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 22:19
 */

namespace Core;


class ResponseJson extends Response
{
    public function __construct($content)
    {
        parent::__construct($content);
    }

    public function getContentType(): string
    {
        return 'application/json';
    }
}