
<?
use Bitrix\Main\Page\Asset;

Asset::getInstance()->addCss("https://use.fontawesome.com/releases/v5.0.13/css/solid.css");
Asset::getInstance()->addCss("https://use.fontawesome.com/releases/v5.0.13/css/fontawesome.css");

//echo $arParams['SUSBSCRIBE_ID'];


?>


<div class="footer-top">
  <div class="footer-left-float footer-top-pad footer-lm5">
    <i class="footer-left-float fas fa-envelope fa-2x"></i>
    <p class="footer-left-float footer-lm15">Подпишитесь! Новости, акции, предложения!<p>
  </div>
  <div class="footer-right-float footer-top-pad" id="subscibe-form-div">
    <a class="footer-right-float sv_button footer-lm15" id="subscribe-button" href=javascript:void(0) >Подписаться</a>
    <div id="subscribe"  class="footer-right-float search-form">
      <form method="post" id="subscribe-form">
         <input type="hidden" name="subscribe_id" value="<?=base64_encode(serialize($arParams['SUSBSCRIBE_ID']));?>">
    	   <input type="text" id="email-input" name="email" value="<?=$arResult['EMAIL']?>" class="input placeholder" placeholder="Введите email">
       </form>
    </div>
  </div>

  <div class="footer-right-float footer-top-pad" id="subscibe-placeholder-div" style="display: none;" >
    <p class="footer-right-float" >Подписка оформлена</p>
  </div>

  <div class="footer-right-float footer-top-pad" id="subscibe-alert-div" style="display: none;" >
    <p class="footer-right-float footer-alert" >Неверный емайл</p>
  </div>
</div>


<? $link =  $this->getFolder()."/subscribe.php";?>


<style>
  .footer-alert
  {
    color:red;
  }
</style>
<script>
var link = "<?=$link?>";
console.log(link);
</script>
