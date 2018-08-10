<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 06.08.2018
 * Time: 14:33
 */

namespace olof_spammer\Entity;

use Bitrix\Main\Entity,
    Bitrix\Main\Entity\DataManager,
    Bitrix\Main\Type;


class EmailTable extends DataManager
{
    public static function getTableName()
    {
        return 'olof_spammer_email';
    }

    public static function getMap()
    {
        return [
            new Entity\IntegerField('id', [
                'primary' => true,
                'autocomplete' => true
            ]),
            new Entity\StringField('email'),
            new Entity\StringField('page'),
            new Entity\StringField('ip'),
            new Entity\StringField('sdelete', [
                'default_value' => function(){
                    return md5(rand());
                }
            ]),
            new Entity\DateField('date', array(
                'default_value' => new Type\Date
            ))
        ];
    }

    /**
     * @param array $data
     * @param array $subscribes // ['someCode', 'someCode2']
     * @return Entity\AddResult
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Exception
     */
    public static function addEx(array $data, array $subscribes = [])
    {
        $result = EmailTable::add($data);

        $id = $result->getId();

        if(!$subscribes) $subscribes = SubscribeTypeTable::getList([
            'select' => ['code']
        ])->fetchAll();

        if (!$subscribes) return $result;

        $subscribeTypeIds = SubscribeTypeTable::getList([
            'select' => ['id'],
            'filter' => ['=code' => $subscribes]
        ])->fetchAll();


        foreach ($subscribeTypeIds as $subscribeType){
            $subscribeTypeId = $subscribeType['id'];

            SubscribeTable::add([
                'subscribe_id' => $id,
                'subscribe_type_id' => $subscribeTypeId,
            ]);
        }

        return $result;
    }


    public static function deleteEx($id)
    {
        EmailTable::delete($id);
        $subscribeRs = SubscribeTable::getList([
            'select' => 'id',
            'filter' => ['=subscribe_id' =>$id]
        ]);

        while ($subId = $subscribeRs->fetch()){
            SubscribeTable::delete($subId);
        }
    }


    public static function getUserId($email, $secretKey)
    {
        $user = EmailTable::getList([
            'select' => ['id', 'email', 'sdelete'],
            'filter' => ['=email' => $email]
        ])->fetch();

        if(!$user && $user['sdelete']!=$secretKey) return false;

        return $user['id'];
    }

    public static function getByEmail($email)
    {
        $user = EmailTable::getList([
            'select' => ['id', 'email', 'sdelete'],
            'filter' => ['=email' => $email]
        ])->fetch();

        return $user;
    }

    /**
     * @param $email
     * @return mixed
     * @throws \Exception
     */
    public static function getOrCreateByEmail($email)
    {
        $userSubscribe = EmailTable::getByEmail($email);
        if(!$userSubscribe){
            $result = EmailTable::add([
                'email' => $email,
                'page' =>$_SERVER['REQUEST_URI'],
                'ip' =>$_SERVER['REMOTE_ADDR'],
            ]);
            if($result->isSuccess())
            {
                $userSubscribe= $result->getData();
            }else{
                throw new \Exception('Не удалось добавить запись в подписки');
            }
        }
        return $userSubscribe;
    }




    public static function getSubscribesById($id)
    {
        $rs = EmailTable::getList(array(
            'filter' => array('=id' => $id),
            'select' => array(
                'id', 'email',
                'subscribe_code' =>
                    'olof_spammer\Entity\SubscribeTable:subscribe.subscribe_type.code',

                'subscribe_title'=>
                    'olof_spammer\Entity\SubscribeTable:subscribe.subscribe_type.title',
            )
        ));

        return $rs->fetchAll();
    }
}