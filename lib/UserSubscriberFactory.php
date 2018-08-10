<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 06.08.2018
 * Time: 17:44
 */

namespace olof_spammer;


class UserSubscriberFactory
{
    public $lastError;

    public function getUserSubscriber($email, $secretKey): UserSubscriber
    {
        $userId = Entity\EmailTable::getUserId($email, $secretKey);
        if(!$userId) $this->lastError = "Неверная пара ключ-емайл";
        return new UserSubscriber($userId);
    }
}