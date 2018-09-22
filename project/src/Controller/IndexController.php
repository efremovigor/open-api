<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 14:48
 */

namespace Controller;

use Core\Response;
use View\Template\TemplateConst;

class IndexController extends AbstractController
{
    public function indexAction():Response
    {
        $response = new Response();
        $response->setBody($this->getTempater()->render(TemplateConst::INDEX, ['title' => 'Welcome', 'login_value' => $_POST['login'] ?? null]));
        return $response;
    }
}