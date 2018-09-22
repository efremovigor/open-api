<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 22:15
 */

namespace Controller;


use Core\Response;
use Core\ResponseJson;
use Entity\Form\Login;
use Entity\User;
use View\Template\TemplateConst;

class UserController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function loginAction()
    {
        /**
         * @var $form Login
         */
        $form = $this->getSerializer()->normalize($_POST, Login::class);
        if (!$form->isValid()) {
            $this->setRedirectRoute('index');
            return new ResponseJson(['success' => false, 'error' => 'invalid credential']);
        }

        $user = $this->getUserRepository()->getByCred($form);
        if ($user instanceof User) {
            $this->getRedisRepository()->initSession($user);
            return new ResponseJson(['success' => true, 'error' => '']);
        } else {
            return new ResponseJson(['success' => false, 'error' => 'invalid credential']);
        }
    }

    public function profileAction()
    {
        return new Response($this->getTempater()->render(TemplateConst::PROFILE, ['title' => 'Profile']));
    }
}