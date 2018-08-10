<?php

require_once $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php";
use Bitrix\Main\Loader;
$moduleId = "olof_spammer";

Loader::includeModule($moduleId);

use olof_spammer\ReportViewHelper\SubscriberReportViewer;

if ($APPLICATION->GetGroupRight($moduleId) == "D") {
    $APPLICATION->AuthForm("Не достаточно прав");
}
$APPLICATION->SetTitle("Удаление значений свойств");

$errors = [];
$success = [];

$APPLICATION->SetTitle("Подписки (olof)");


$reportViewer = new SubscriberReportViewer($_GET, "report_item_list");

$reportViewer->fillAdminTable();

$reportViewer->getAdminList()->CheckListMode();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$reportViewer->getFilterForm("find_form", $APPLICATION->GetCurPage());
$reportViewer->getAdminList()->DisplayList();
require $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php";