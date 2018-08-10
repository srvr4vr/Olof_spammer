<?php

\Bitrix\Main\Loader::includeModule('olof_spammer');

use olof_spammer\Entity;

$subscribeTypeList =array_reduce(Entity\SubscribeTypeTable::getList()->fetchAll(),
    function($carry, $item){
        $carry[$item['code']] = $item['title'];
        return $carry;
    }, []);



$arComponentParameters = array(
   "GROUPS" => array(
      "SETTINGS" => array(
         "NAME" => "Настройки"
      ),
   ),
   "PARAMETERS" => array(
      "SUSBSCRIBE_ID" => array(
          "PARENT" => "SETTINGS",
          "NAME" => "Подписка",
          "MULTIPLE" => "Y",
          "TYPE" => "LIST",
          "VALUES" => $subscribeTypeList,
      ),
   )
);

