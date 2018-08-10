<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


use Bitrix\Main\Loader,
    olof_spammer\Entity\EmailTable,
    olof_spammer\UserSubscriberFactory;

$email = $_POST['email'];
$subscribeId = $_POST['subscribe'] ?? [];



try {
    Loader::includeModule('olof_spammer');
    $userSubscribe = EmailTable::getByEmail($email);
    $subscribeFactory = new UserSubscriberFactory();
    $subscriber = $subscribeFactory->getUserSubscriber(
        $userSubscribe['email'],
        $userSubscribe['sdelete']
    );
    if($subscribeFactory->lastError) return "error";

    $subscriber->updateSubscribes($subscribeId);?>
    <p>Вы успешно отредактировали подписки</p>
    <?return "ok";
} catch (Exception $exception) {
    return "error";
}

