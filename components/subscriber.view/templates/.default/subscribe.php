<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader,
    olof_spammer\Entity\EmailTable,
    olof_spammer\UserSubscriberFactory;

$email = $_POST['email'];
$subscribeId = unserialize(base64_decode($_POST['subscribe_id']));



try {
    Loader::includeModule('olof_spammer');
    $userSubscribe = EmailTable::getOrCreateByEmail($email);
    $subscribeFactory = new UserSubscriberFactory();
    $subscriber = $subscribeFactory->getUserSubscriber(
        $userSubscribe['email'],
        $userSubscribe['sdelete']
    );
    $subscriber->updateSubscribes($subscribeId);
    return "ok";
} catch (Exception $exception) {
    return "error";
}

