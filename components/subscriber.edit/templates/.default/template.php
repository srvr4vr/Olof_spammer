<?php


function inArray($option, $array): bool
{
    foreach ($array as $item){
        if($option==$item['subscribe_type_id']) return true;
    }
    return false;

}
?>

<?if($_POST):?>
<div class="alert alert-success alert-box" role="alert">
    Вы успешно сохранили настройки подписок.
</div>
<?endif;?>

<p class="subscribe__title">Вы подписаны на следующие рассылки:</p>
<div class="subscribe__box">
    <form action="<?=POST_FORM_ACTION_URI?>" method="post">
        <?foreach($arResult['ITEMS'] as $subscribe):?>

            <div><label><input name="subscribe[]" value="<?=$subscribe['code']?>"
                            <?=inArray($subscribe['id'], $arResult['USER_SUSCRIBES'])?"checked":"";?>

                            type="checkbox" id="<?=$subscribe['code']?>" name="<?=$subscribe['code']?>"/>
                    <?=$subscribe['title']?></label></div>
        <?endforeach;?>
        <input type="hidden" name="key" value="<?=$arParams['key']?>">
        <input type="hidden" name="email" value="<?=$arParams['email']?>">
        <p class="unsubscribe_text_gray">Cнимите галочки с тех подписок, от которых хотите отказаться и нажмите Сохранить</p>
        <input type="submit" value="Сохранить" class="bx_unsubscribe_btn">
    </form>
</div>





