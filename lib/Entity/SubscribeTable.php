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

class SubscribeTable extends DataManager
{
    public static function getTableName()
    {
        return 'olof_spammer_subscribes';
    }

    public static function getMap()
    {
        return [
            new Entity\IntegerField('id', [
                'primary' => true,
                'autocomplete' => true
            ]),
            new Entity\IntegerField('subscribe_id'),
            new Entity\IntegerField('subscribe_type_id'),

            new Entity\ReferenceField(
                'subscribe',
                'olof_spammer\Entity\EmailTable',
                array('=this.subscribe_id' => 'ref.id')
            ),

            new Entity\ReferenceField(
                'subscribe_type',
                'olof_spammer\Entity\SubscribeTypeTable',
                array('=this.subscribe_type_id' => 'ref.id')
            ),

        ];
    }


}