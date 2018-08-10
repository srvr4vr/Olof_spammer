<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 06.08.2018
 * Time: 17:40
 */

namespace olof_spammer;

use  olof_spammer\Entity;
use  Bitrix\Main\Mail\Event;

class Spammer
{
    protected $messageTypes;
    protected $siteId;
    /**
     * @var string
     */
    private $postEvent;
    /**
     * @var array
     */
    private $customArgs;


    /**
     * Spammer constructor.
     * @param array $messageTypes Массив кодов событий
     * @param string $siteId
     * @param string $postEvent Кастомное почтовое событие (=игнорировать значение из бд)
     * @param array $customArgs Кастомные аргументы для события
     */
    public function __construct(array $messageTypes, $siteId = SITE_ID, $postEvent = "", $customArgs=[])
    {
        $this->messageTypes = $messageTypes;
        $this->siteId = $siteId;
        $this->postEvent = $postEvent;
        $this->customArgs = $customArgs;
    }

    /**
     * @param string $name Заголовок события (имя акции, заголовок новостной статьи)
     * @param string $link Ссылка на событие/статью на сайте
     */
    public function execute($name, $link, $picture="")
    {
        $recipients = $this->findRecipients();
        $this->sendForRecipients($recipients, $name, $link, $picture);
    }

    public function getApiFolder()
    {
        return $_SERVER['DOCUMENT_ROOT']."/../api";
    }

    protected function findRecipients(): array
    {
        $recipients = Entity\SubscribeTable::getList([
            'select' => [
                'email'=>'subscribe.email',
                'key'=>'subscribe.sdelete',
                'event' => 'subscribe_type.event'
            ],

            'filter' => ['=subscribe_type.code' => $this->messageTypes]
        ])->fetchAll();
        return $recipients;
    }

    protected function sendForRecipients(array $recipients, $name, $link, $picture="")
    {
        foreach ($recipients as $arClient){
            $args = $this->customArgs ? $this->customArgs : array(
                "EMAIL" => $arClient['email'],
                "KEY" => $arClient['key'],
                "EVENT_NAME" => $name,
                "EVENT_LINK" => $link,
                "DETAIL_PICTURE" => $picture,
            );

            Event::send(array(
                "EVENT_NAME" => ($this->postEvent)  ? $this->postEvent
                                                    : $arClient['event'],
                "LID" => $this->siteId,
                "C_FIELDS" => $args,
            ));
        }
    }
}