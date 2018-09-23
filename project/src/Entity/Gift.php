<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 14:10
 */

namespace Entity;


use Core\Service\Entity\PropertyAccessInterface;

/**
 * Class Gift
 * @package Entity
 */
abstract class Gift implements GiftInterface, PropertyAccessInterface
{
    protected $giftId;
    protected $userId;
    protected $type;
    protected $data;
    protected $send;
    protected $limit;

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return [
            'gift_id',
            'user_id',
            'type',
            'data',
            'send',
        ];
    }

    /**
     * @param mixed $limit
     */
    public function setLimit($limit): void
    {
        $this->limit = $limit;
    }

    public function getGiftId(): ?int
    {
        return $this->giftId;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getSend()
    {
        return $this->send;
    }

    /**
     * @param mixed $send
     */
    public function setSend($send): void
    {
        $this->send = $send;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param mixed $giftId
     */
    public function setGiftId($giftId): void
    {
        $this->giftId = $giftId;
    }

    /**
     * @return mixed
     */
    public function getType(): string
    {
        return $this->type;
    }
}