<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 06.08.2018
 * Time: 17:43
 */

namespace olof_spammer;

use olof_spammer\Entity\EmailTable;
use olof_spammer\Entity\SubscribeTable;
use olof_spammer\Entity\SubscribeTypeTable;


class UserSubscriber
{
    protected $subscribeId;

    public function __construct($userId)
    {
        $this->subscribeId = $userId;
    }

    public function updateSubscribes(array $subscribes)
    {
        $userCodes = array_column(EmailTable::getSubscribesById($this->subscribeId),
            'subscribe_code'
        );

        $codeToAdd = array_diff($subscribes, $userCodes);
        $codeToDelete = array_diff($userCodes, $subscribes);

        $this->removeSubscribes($codeToDelete);
        $this->addSubscribes($codeToAdd);

    }

     public function getAllSubscribe()
     {
         return SubscribeTypeTable::getList()->fetchAll();
     }

     public function getUserSubscribe()
     {
         return SubscribeTable::getList([
             'filter' => [
                 '=subscribe_id' => $this->subscribeId,
             ]
         ])->fetchAll();
     }

    public function removeSubscribes(array $subscribes)
    {
        $subIdForDelete = SubscribeTable::getList([
            'select' => ['id'],
            'filter' => [
                '=subscribe_type.code' => $subscribes,
                '=subscribe_id' => $this->subscribeId,
            ]
        ])->fetchAll();

        foreach ($subIdForDelete as $subId) {
            SubscribeTable::delete($subId);
        }
    }

    public function addSubscribes(array $subscribes)
    {
        $userCodes = array_column(EmailTable::getSubscribesById($this->subscribeId), 'subscribe_code');
        $codeToAdd = array_diff($subscribes, $userCodes);
        $this->addSubscriptionInternal($codeToAdd);
    }

    protected function addSubscriptionInternal(array $subscriptions)
    {
        foreach ($subscriptions as $code) {
            $id = SubscribeTypeTable::getIdByCode($code);
            if (!$id) continue;

            SubscribeTable::add([
                'subscribe_type_id' => $id,
                'subscribe_id' => $this->subscribeId,
            ]);
        }
    }
}