<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 14:17
 */

namespace Entity;


interface GiftInterface
{
    public function getGiftId(): ?int;

    public function getType(): ?string;

    public function getUserId(): ?int;

    public function setUserId(int $userId): void;

    public function getSender(): string;

    public function getData(): ?array;

    public function setSend(?bool $state): void;
}