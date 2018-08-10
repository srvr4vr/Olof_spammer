<?php

namespace olof_spamer\components;

\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
\Bitrix\Main\Loader::includeModule('olof_spammer');

use olof_spammer\Entity;
use olof_spammer\UserSubscriberFactory;


class SubscriberEdit extends \CBitrixComponent
{
    public function executeComponent()
    {
        $this->run();
    }

    public function run()
    {


        $factory = new UserSubscriberFactory();

        $email = $this->arParams['email'];
        $key   = $this->arParams['key'];


        $subscriber = $factory->getUserSubscriber($email, $key);


        if($factory->lastError){
            $this->includeComponentTemplate('error');
            return;
        }


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $subscribeId = $_POST['subscribe'] ?? [];
            $subscriber->updateSubscribes($subscribeId);
            $this->arResult['IS_UPDATED']=true;
            header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?ok');
        }



        $possibleSubscribes = $subscriber->getAllSubscribe();

        $userSubscribes = $subscriber->getUserSubscribe();




        $this->arResult['ITEMS'] = $possibleSubscribes;
        $this->arResult['USER_SUSCRIBES'] = $userSubscribes;



        $this->includeComponentTemplate();
    }
}
