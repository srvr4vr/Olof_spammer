<?php

namespace olof_spamer\components;

\Bitrix\Main\Localization\Loc::loadMessages(__FILE__);
\Bitrix\Main\Loader::includeModule('olof_spammer');

use olof_spammer\Entity;


class SubscriberView extends \CBitrixComponent
{
    public function executeComponent()
    {
        $this->run();
    }

    public function run()
    {
        global $USER;

        $email ="";

        if ($USER->IsAuthorized())
        {
            $email = $USER->GetEmail();
        }

        $this->arResult['EMAIL'] = $email;

        $subscription = Entity\EmailTable::getByEmail($email);

        if($subscription){
            $this->arResult['ALLREADY_EXIST']=true;
        }
        $this->includeComponentTemplate();
    }
}
