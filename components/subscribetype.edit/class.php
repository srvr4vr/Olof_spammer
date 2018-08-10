<?php

namespace olof_spamer\components;

\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
\Bitrix\Main\Loader::includeModule('olof_spammer');
\Bitrix\Main\Loader::includeModule('iblock');

use Bitrix\Iblock\IblockTable;
use olof_spammer\Entity;
use olof_spammer\UserSubscriberFactory;


class SubscribetypeEdit extends \CBitrixComponent
{
    public function executeComponent()
    {
        $this->run();
    }

    protected function getPossibleIlocks()
    {
        return IblockTable::getList([
            'select' => ['ID', 'NAME']
        ])->fetchAll();
    }

    protected function isValidateSuccess(array $item): bool
    {
        if(intval($item['id']) < 0 && boolval($item['is_delete'])) return false;
        if(!$item['code']) return false;


        return true;
    }
    protected function deleteSubscribeType($item)
    {
        echo "<pre>";
        var_dump($item['id']);
        echo "</pre>";
        Entity\SubscribeTypeTable::delete($item['id']);
    }

    protected function prepareData($item)
    {
        $result = [];
        $result['code'] = $item['code'];
        $result['title'] = $item['title'];
        $result['event'] = $item['event'];
        $result['iblock_id'] = $item['iblock_id'];
        return $result;
    }

    protected function addOrUpdateSubscribeType($item)
    {
        if($item['id']<0) {
            $data = $this->prepareData($item);
            Entity\SubscribeTypeTable::add($data);
        }elseif(Entity\SubscribeTypeTable::isCodeExist($item['code'])){
            Entity\SubscribeTypeTable::update($item['id'], $this->prepareData($item));
        }
    }



    public function run()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            echo "<pre>";
            var_dump($_POST);
            echo "</pre>";
            foreach ($_POST['items'] as $item){
                if(!$this->isValidateSuccess($item)) continue;


                if($item['is_delete']) {

                    echo "<pre>";
                    var_dump($item);
                    echo "</pre>";
                    $this->deleteSubscribeType($item);
                }else{
                    $this->addOrUpdateSubscribeType($item);
                }
            }

            $_POST = array();
            header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?ok');

        }





        $subscribeTypes = Entity\SubscribeTypeTable::getList()->fetchAll();

        $this->arResult['ITEMS'] = $subscribeTypes;
        $this->arResult['IBLOCKS'] = $this->getPossibleIlocks();


        $this->includeComponentTemplate();
    }


}
