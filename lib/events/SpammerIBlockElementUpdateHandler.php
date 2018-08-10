<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 08.08.2018
 * Time: 9:16
 */

namespace olof_spammer\events;

use olof_spammer;
use Bitrix\Main\Loader;
use Bitrix\Main\Diag\Debug;


class SpammerIBlockElementUpdateHandler
{
    public static function runStatic(&$fields)
    {
        $self = new self();
        return $self->run($fields);
    }

    protected function inArray($arg, array $array)
    {
        foreach ($array as $item) {
            if($arg == $item) return true;
        }
        return false;
    }

    protected function getSubscribeType($iblockId)
    {
        return olof_spammer\Entity\SubscribeTypeTable::getList([
            'select' => ['iblock_id', 'code'],
            'filter' => ['=iblock_id' => $iblockId]
        ])->fetch();
    }

    protected function getSeendMessagePropId($iblockId)
    {
        return \Bitrix\Iblock\PropertyTable::getList([
            'select' => ['ID'],
            'filter' => ['=IBLOCK_ID'=> $iblockId, '=CODE'=>'SEND_MAIL']
        ])->fetch()['ID'];
    }

    protected function ifSendMailTrue($prop): bool
    {
        $result = false;
        foreach ($prop as $id => $item){
            if($item['VALUE'] == "Y") $result = true;
        }
        return $result;
    }

    protected function getPropWithFalseSendMail($props, $propSendMessageId)
    {
        foreach ($props[$propSendMessageId] as $id => $item){
            $props[$propSendMessageId][$id]['VALUE'] = "N";
        }
        return $props;
    }

    public static $disallow = false;

    public function run(&$arFields)
    {
        if (self::$disallow) return false;
        self::$disallow = true;
        $iblockId = (int)$arFields['IBLOCK_ID'];
        $elementId = intval($arFields['ID']);

        $subscribeType = $this->getSubscribeType($iblockId);

        if(!$subscribeType) return false;

        $propSendMessageId = $this->getSeendMessagePropId($iblockId);
        $prop = $arFields['PROPERTY_VALUES'];

        if(!$this->ifSendMailTrue($prop[$propSendMessageId])) return false;

        $prop = $this->getPropWithFalseSendMail($prop, $propSendMessageId);

        Loader::includeModule("olof_spammer");

        $notifyType = $subscribeType['code'];

        $spammer = new olof_spammer\Spammer([$notifyType], 's1');

        $img_path = \CFile::GetPath($arFields['DETAIL_PICTURE']['old_file']);
        $img_path = $_SERVER['HTTP_ORIGIN'].$img_path;

        Debug::dumpToFile($arFields, "", "/log/log-new.txt");

        Debug::dumpToFile($img_path, "", "/log/log-new.txt");
        $spammer->execute(
            $arFields['NAME'],
            $arFields['DETAIL_PAGE_URL'],
            $img_path
        );

        $el = new \CIBlockElement();
        self::$disallow = false;

        $el->Update($elementId, array(
            'PROPERTY_VALUES' => $prop,
        ));

        return true;
    }
}