<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 06.08.2018
 * Time: 15:01
 */

namespace olof_spammer\Entity;

use Bitrix\Main\Entity,
    Bitrix\Main\Entity\DataManager;

class SubscribeTypeTable extends DataManager
{
    public static function getTableName()
    {
        return 'olof_spammer_subscribe_type';
    }

    public static function getMap()
    {
        return [
            new Entity\IntegerField('id', [
                'primary' => true,
                'autocomplete' => true,
            ]),

            new Entity\StringField('code', [
                'required' => true,
            ]),
            new Entity\StringField('title'),
            new Entity\StringField('event'),
            new Entity\IntegerField('iblock_id'),
        ];
    }

    public static function isCodeExist($code)
    {
        $rs = SubscribeTypeTable::getList([
            'select' => ['code'],
            'filter' => ['=code' => $code]
        ]);
        $ids = $rs->fetchAll();
        return count($ids) > 0;
    }


    public static function getIdByCode($code)
    {
        $rs = SubscribeTypeTable::getList([
            'select' => ['id'],
            'filter' => ['=code' => $code]
        ]);
        $id = $rs->fetch();
        return $id ? $id['id'] : false;
    }

}