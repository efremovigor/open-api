<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 17:03
 */

namespace Repository;


use Entity\GiftInterface;

class GiftRepository extends AbstractOrmRepository
{

    /**
     * Сохранение подарка
     * @param GiftInterface $gift
     * @throws \Exception
     */
    public function save(GiftInterface $gift)
    {
        $data = $this->serializer->normalize($gift);
        /**
         * @todo save by id
         */
        $this->update(sprintf('UPDATE gift SET ... WHERE gift_id = "%d"',$gift->getGiftId()));
    }

    /**
     * Добавление подарка
     * @param GiftInterface $gift
     * @throws \Exception
     */
    public function add(GiftInterface $gift)
    {
        $data = $this->serializer->normalize($gift);
        /**
         * @todo save by id
         */
        $this->update(sprintf('INSERT INTO gift ... VALUE(...)',$data));
    }
}