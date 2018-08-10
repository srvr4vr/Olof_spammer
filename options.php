<? if (!$USER->IsAdmin()) return;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Loader::includeModule($mid);
?>

<div class="adm-detail-block" id="tabControl_layout">
    <div class="adm-detail-tabs-block" id="tabControl_tabs" style="left: 0px;">
        <span title="Общие настройки для компонентов модуля ( Ctrl+Alt+Q ) " id="tab_cont_edit1"
              class="adm-detail-tab adm-detail-tab-active" onclick="tabControl.SelectTab('edit1');">Настройки</span>
        <div class="adm-detail-title-setting" onclick="tabControl.ToggleTabs();"
             title="Развернуть все вкладки на одну страницу" id="tabControl_expand_link"><span
                    class="adm-detail-title-setting-btn adm-detail-title-expand"></span></div>
        <div onclick="tabControl.ToggleFix('top')" class="adm-detail-pin-btn-tabs" title="Открепить панель"></div>
    </div>
    <div class="adm-detail-content-wrap">
        <div class="adm-detail-content" id="fedit1">
            <div class="adm-detail-title">Основные настройки</div>
            <div class="adm-detail-content-item-block">
            <?
                $APPLICATION->IncludeComponent(
                    "olof_spammer:subscribetype.edit",
                    ".default",
                    array(
                        "COMPONENT_TEMPLATE" => ".default",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                    ),
                    false
                );
            ?>
        </div>

        </div>
    </div>
</div>



