<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 09.08.2018
 * Time: 13:34
 */

namespace olof_spammer;

use olof_spammer\Entity;
use olof_spammer\Interfaces\ItemProviderInterface;


class SubscriberReportProvider implements ItemProviderInterface
{
    /**
     * @return ColumnData[]
     * @throws \Bitrix\Main\ArgumentException
     */
    public function getMap(): array
    {
        $item = Entity\EmailTable::getList([
            'select' => [
                'id', 'email',
                'subscribe_code' =>
                    'olof_spammer\Entity\SubscribeTable:subscribe.subscribe_type.code',
                'date',
            ],
        ]);

        $keys = array_keys($item->getFields());

        return array_map(function($item){
            return ColumnData::createByName($item);
        }, $keys);
    }

    public function getList(array $filter = [], array $order=[])
    {
        return Entity\EmailTable::getList([
            'select' => [
                'id', 'email',
                'subscribe_code' =>
                    'olof_spammer\Entity\SubscribeTable:subscribe.subscribe_type.code',
                'date',
            ],
            'filter' => $filter,
            'order' => $order,
        ]);
    }

    /**
     * @return Filter[]
     */
    public function getFilters(): array
    {
        $result = [];
        $result[] = new Filter('email', 'Email','simple');
        $result[] = new Filter('subscribe_code', 'Подписка','select');
       // $result[] = new Filter('date', 'Дата добавления в БД','date');
        return $result;
    }

    public function getUniqueValuesFromField($columnName): array
    {
        $items = $this->getList()->fetchAll();
        $map =  array_column($items, 'subscribe_code');
        return array_unique($map);
    }
}