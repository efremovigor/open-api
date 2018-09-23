<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 20:19
 */

namespace Controller;


use Core\ResponseJson;
use Repository\GiftRepository;
use Service\GiftService;
use Service\RepositoryConst;
use Service\ServiceConst;
use Service\Session;

class GiftController extends AbstractController
{
    /**
     * Экшен получение подарка
     * @return ResponseJson
     * @throws \Exception
     */
    public function getGiftAction()
    {
        $user = $this->getSession()->getUser();
        if ($user === null) {
            return new ResponseJson(['success' => false, 'error' => 'not access']);
        }
        $gift = $this->getGiftService()->getGift();
        if ($gift === null) {
            return new ResponseJson(['success' => false, 'error' => 'gift is not available']);
        }
        $gift->setUserId($user->getId());
        $this->getGiftRepository()->add($gift);

        return new ResponseJson(['success' => true, 'error' => 'gift is not available', 'data' => $this->getSerializer()->normalize($gift)]);
    }

    /**
     * @return GiftRepository
     */
    private function getGiftRepository(): GiftRepository
    {
        return $this->container->get(RepositoryConst::GIFT);
    }

    public function getSession(): Session
    {
        return $this->container->get(ServiceConst::SESSION);
    }


    public function getGiftService(): GiftService
    {
        return $this->container->get(ServiceConst::GIFT_SERVICE);
    }
}