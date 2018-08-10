<?php


function inArray($option, $array): bool
{
    foreach ($array as $item) {
        if ($option == $item['subscribe_code']) return true;
    }
    return false;
}

?>

<div id="templates" style="display: none">
    <table>
        <tr class="subscribe-control">
            <input type="hidden" value="-1" name="items[%id%][id]">
            <td><input name="items[%id%][code]" type="text"/></td>
            <td><input name="items[%id%][title]" type="text"/></td>
            <td><input name="items[%id%][event]" type="text"/></td>
            <td>
                <select name="items[%id%][iblock_id]">
                    <option value="-1">Нет</option>
                    <? foreach ($arResult['IBLOCKS'] as $block): ?>
                        <option value="<?= $block['ID'] ?>"><?= "[{$block['ID']}] {$block['NAME']}" ?></option>
                    <? endforeach; ?>
                </select>
            </td>
            <td>
                <input name="items[%id%][is_delete]" type="hidden" value="0"/>
                <input name="items[%id%][is_delete]" type="checkbox" value="1"/>
            </td>
        </tr>
    </table>
</div>

<? if ($_POST): ?>
    <div class="alert alert-success alert-box" role="alert">
        Успешно сохранено.
    </div>
<? endif; ?>

<p class="subscribe__title">Подписки:</p>

<form action="<?= POST_FORM_ACTION_URI ?>" method="post">

    <div class="subscribe__box">
        <table>
            <tr>
                <th>Код</th>
                <th>Название</th>
                <th>Событие</th>
                <th>Инфоблок</th>
                <th>Удалить</th>
            </tr>
            <?php $i=1;?>
            <? foreach ($arResult['ITEMS'] as $subscribe): ?>
                <tr class="subscribe-control">
                    <input type="hidden" value="<?=$subscribe['id']?>" name="items[<?=$i?>][id]">
                    <td><input name="items[<?=$i?>][code]" type="text" value="<?=$subscribe['code']?>" /></td>
                    <td><input name="items[<?=$i?>][title]" type="text" value="<?=$subscribe['title']?>" /></td>
                    <td><input name="items[<?=$i?>][event]" type="text" value="<?=$subscribe['event']?>" /></td>
                    <td>
                        <select name="items[<?=$i?>][iblock_id]">
                            <option value="-1">Нет</option>
                            <? foreach ($arResult['IBLOCKS'] as $block): ?>
                                <option <?=$subscribe['iblock_id']==$block['ID']?"selected":"";?>  value="<?= $block['ID'] ?>"><?= "[{$block['ID']}] {$block['NAME']}" ?></option>
                            <? endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input name="items[<?=$i?>][is_delete]" type="hidden" value="0"/>
                        <input name="items[<?=$i?>][is_delete]" type="checkbox" value="1"/>
                    </td>
                </tr>
            <?php $i++;?>


            <? endforeach; ?>
        </table>
    </div>

    <input id="add_button" type="button" value="Добавить" class="bx_big bx_bt_button bx_cart">

    <input type="submit" value="Сохранить" class="bx_unsubscribe_btn">
</form>

<script>

    var items =

    String.prototype.replaceAll = function(search, replacement) {
        var target = this;
        return target.replace(new RegExp(search, 'g'), replacement);
    };

    $(document).ready(function () {
        $('#add_button').click(function () {
            var id = $('.subscribe__box table tr').length -1;



            var controlHtml = $('#templates table tbody')[0].innerHTML;

            controlHtml = controlHtml.replaceAll('%id%', id);
            $('.subscribe__box table').append(controlHtml);

            console.log(controlHtml);

            //$('.subscribe__box table').append(control);

        });
    });


</script>