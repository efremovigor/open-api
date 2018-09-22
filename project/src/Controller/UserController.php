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
        try{
            /**
             * @var $form Login
             */
            $form = $this->getSerializer()->normalize($_POST, Login::class);
            if (!$form->isValid()) {
                $this->setRedirectRoute('index');
                $data = ['success' => false, 'error' => 'invalid credential'];
            }else{
                $user = $this->getUserRepository()->getByCred($form);
                if ($user instanceof User) {
                    $this->getRedisRepository()->initSession($user);
                    $data = ['success' => true, 'error' => ''];
                } else {
                    $data = ['success' => false, 'error' => 'invalid credential'];
                }
            }
        }catch (\Throwable $exception){
            $data = ['success' => false, 'error' => 'service is down'];
        }

        return new ResponseJson($this->getSerializer()->serialize($data));
    }

    public function profileAction()
    {
        return new Response($this->getTempater()->render(TemplateConst::PROFILE, ['title' => 'Profile']));
    }
}